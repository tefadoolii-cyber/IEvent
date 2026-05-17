<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = SupportTicket::with('user');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->status)   $query->where('status', $request->status);
        if ($request->priority) $query->where('priority', $request->priority);

        $tickets = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'open'        => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved'    => SupportTicket::where('status', 'resolved')->count(),
            'total'       => SupportTicket::count(),
        ];

        return view('support_tickets.index', compact('tickets', 'stats'));
    }

    public function show(SupportTicket $supportTicket)
    {
        $supportTicket->load(['user', 'resolvedBy']);
        return view('support_tickets.show', compact('supportTicket'));
    }

    public function update(Request $request, SupportTicket $supportTicket)
    {
        $request->validate([
            'status'           => 'required|in:open,in_progress,resolved,closed',
            'resolution_notes' => 'nullable|string',
        ]);

        $data = [
            'status'           => $request->status,
            'resolution_notes' => $request->resolution_notes,
        ];

        if (in_array($request->status, ['resolved', 'closed']) && !$supportTicket->resolved_at) {
            $data['resolved_by'] = Auth::id();
            $data['resolved_at'] = now();
        }

        $supportTicket->update($data);
        return redirect()->back()->with('success', 'تم تحديث حالة التذكرة');
    }

    public function destroy(SupportTicket $supportTicket)
    {
        $supportTicket->delete();
        return redirect()->route('support-tickets.index')->with('success', 'تم حذف التذكرة');
    }
}
