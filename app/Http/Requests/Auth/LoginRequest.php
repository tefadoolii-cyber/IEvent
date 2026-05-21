<?php

namespace App\Http\Requests\Auth;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $username = trim($this->input('username'));
        $password = $this->input('password');
        $remember = $this->boolean('remember');

        // حدد البريد الإلكتروني المرتبط بهذا المستخدم
        $email = $this->resolveEmail($username);

        if (!$email || !Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => 'بيانات الدخول غير صحيحة.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    // يحوّل رقم الهوية أو البريد إلى البريد المسجّل في users
    private function resolveEmail(string $username): ?string
    {
        // إذا يبدو بريداً إلكترونياً
        if (str_contains($username, '@')) {
            return $username;
        }

        // ابحث بـ employee_number في جدول الموظفين
        $employee = Employee::where('employee_number', $username)->first();
        if ($employee && $employee->user) {
            return $employee->user->email;
        }

        // أخيراً — جرّب البريد مباشرة (للأدمن والـ hr بدون employee)
        $user = User::where('email', $username)->first();
        return $user?->email;
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('username')) . '|' . $this->ip());
    }
}
