<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    /****LoginPage Function****/
    public function login()
    {
        return view('auth.login');
    }

    /****RegisterPage Function****/
    public function register()
    {
        return view('auth.register');
    }

    /****SignUp Function****/

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verification_token' => Str::uuid(),
        ]);

        Mail::to($user->email)->send(new VerifyEmail($user));

        return redirect()->route('login')
            ->with('status', 'Verification email sent. Please check your inbox.');
    }

    public function verifyEmail($token)
    {

        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Invalid or expired verification link.']);
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        Auth::logout(); // force clean state

        return redirect()->route('login')
            ->with('status', 'Email verified successfully! You can now login.');
    }



    /****LoginAuth Function****/
    public function loginAction(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Invalid login credentials.',
            ]);
        }

        $user = Auth::user();

        if (is_null($user->email_verified_at)) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Please verify your email before logging in.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /****DashboardPage Function****/
    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect()->route('login');
    }

    /****Logout Function****/
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /****UpdatePassword Function****/
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'oldpasswordInput' => ['required', 'current_password'],
            'newpasswordInput' => ['required', PasswordRule::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['newpasswordInput']),
        ]);

        return back()->with('status', 'Password updated successfully!');
    }

    /****UpdateUserData Function****/
    public function update(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
    ]);

    $user->update($validated);

    //  AJAX response
    if ($request->ajax()) {
        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully!',
        ]);
    }

    return back()->with('success', 'Profile updated successfully!');
}


    /****ForgotPasswordPage Function****/
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /****ResetPasswordLink Function****/
    public function sendResetLink(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /****ResetFormPage Function****/
    public function showResetForm(Request $request, $token)
    {
        return view('reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /****ResetPassword Function****/
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Password reset successfully!')
            : back()->withErrors(['email' => __($status)]);
    }
}
