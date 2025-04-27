<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;


class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // First determine if the input is email or username
    $login_by = filter_var($request->input('login_by'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    $request->merge([$login_by => $request->input('login_by')]);
    
    // Then validate based on which one it is
    $request->validate([
        'email' => 'required_without:username|email|exists:users,email',
        'username' => 'required_without:email|string|exists:users,username'
    ]);
    
    // Debug line - consider adding this temporarily
    Log::info('Sending password reset for ' . $login_by . ': ' . $request->input($login_by));
    
    // Send the reset link
    $status = Password::sendResetLink(
        $request->only($login_by)
    );
    
    // Another debug line
    Log::info('Password reset status: ' . $status);
    
    return $status == Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withInput($request->only('login_by'))
            ->withErrors(['login_by' => __($status)]);
}
}
