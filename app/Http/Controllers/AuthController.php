<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class AuthController extends Controller
{
    public function login_admin()
    {
        if (Auth::check() && Auth::user()->is_admin == 1 && Auth::user()->status == 0) {
            return redirect()->intended('/admin/dashboard');
        } else if (Auth::check() && Auth::user()->is_admin == 1 && Auth::user()->status == 1) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Your account has been deactivated. Please contact administrator.');
        }
        return view('admin.auth.login');
    }

    public function auth_login_admin(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_admin' => 1, 'status' => 0], $remember))
        {
            // Add your logic here for successful login
            return redirect()->intended('/admin/dashboard');
        }
        else
        {
            // Check if the user exists but is inactive
            $user = \App\Models\User::where('email', $request->email)
                                 ->where('is_admin', 1)
                                 ->where('status', 1)
                                 ->first();
                                 
            if($user) {
                return redirect()->back()->with('error', 'Your account has been deactivated. Please contact administrator.');
            }
            
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function logout_admin()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    // User registration method
    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'agree_terms' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('register_modal', true); // This will trigger the modal to stay open
        }

        // Handle profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $filename = time() . '_' . $image->getClientOriginalName();
            $profilePicturePath = 'uploads/profile_pictures/' . $filename;
            
            // Make sure the directory exists
            if (!file_exists(public_path('uploads/profile_pictures'))) {
                mkdir(public_path('uploads/profile_pictures'), 0777, true);
            }
            
            // Move the file to the uploads directory
            $image->move(public_path('uploads/profile_pictures'), $filename);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0, // This is a customer account
            'status' => 0, // Account is active
            'profile_picture' => $profilePicturePath,
        ]);

        try {
            event(new Registered($user));
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
            // Don't mark as verified, just notify the user about the issue
        }

        // Return to the same page with success message, but show the sign-in tab
        return redirect()->back()
            ->with('success', 'Registration successful! Please check your email to verify your account. If you don\'t receive an email, please contact support.')
            ->with('login_modal', true); // This will open the modal with the login tab
    }

    // User login method
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');
        
        // Check if user exists and is not deleted
        $user = User::where('email', $request->email)
                   ->where('is_delete', 0)
                   ->first();
        
        if (!$user) {
            return redirect()->back()
                ->with('error', 'These credentials do not match our records.')
                ->with('login_modal', true);
        }
        
        // Check if user is inactive - IMPORTANT: This prevents deactivated users from logging in
        if ($user->status == 1) {
            return redirect()->back()
                ->with('error', 'Your account has been deactivated. Please contact administrator.')
                ->with('login_modal', true);
        }
        
        // Check if user is an admin (they should use admin login)
        if ($user->is_admin == 1) {
            return redirect()->back()
                ->with('error', 'Please use the admin login page.')
                ->with('login_modal', true);
        }
        
        // Attempt authentication first to validate password
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 0], $remember)) {
            // Check if email is verified
            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout(); // Log them out since they haven't verified email
                
                try {
                    // Generate a new verification link
                    $user->sendEmailVerificationNotification();
                    
                    return redirect()->back()
                        ->with('error', 'Please verify your email address before logging in. A new verification link has been sent to your email.')
                        ->with('login_modal', true);
                } catch (\Exception $e) {
                    \Log::error('Failed to send verification email: ' . $e->getMessage());
                    // Still enforce verification but notify the user about the email issue
                    return redirect()->back()
                        ->with('error', 'Please verify your email address before logging in. We couldn\'t send you a new verification link. Please contact support.')
                        ->with('login_modal', true);
                }
            }
            
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        
        return redirect()->back()
            ->with('error', 'The provided credentials do not match our records.')
            ->with('login_modal', true);
    }

    // User logout method
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
    // Email verification notice
    public function verificationNotice()
    {
        // If user is already authenticated and verified, redirect to home
        if (Auth::check() && Auth::user()->hasVerifiedEmail()) {
            return redirect('/')->with('success', 'Your email is already verified.');
        }
        
        // If user is authenticated but not verified, show verification notice
        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            return view('auth.verify-email');
        }
        
        // If user is not authenticated, redirect to login with message
        return redirect()->back()->with('error', 'Please login to access this page.');
    }
    
    // Handle the email verification request
    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);
        
        // Check if URL is valid and hasn't been tampered with
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect('/')->with('error', 'Invalid verification link.');
        }
        
        // Check if user is already verified
        if ($user->hasVerifiedEmail()) {
            return redirect('/')->with('success', 'Your email has already been verified.');
        }
        
        // Mark email as verified
        $user->markEmailAsVerified();
        
        return redirect('/')->with('success', 'Your email has been verified! You can now log in.');
    }
    
    // Resend the email verification link
    public function resendVerificationEmail(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('verification.notice')
                ->with('error', 'You must be logged in to request a verification link.');
        }
        
        $user = Auth::user();
        
        // Check if email is already verified
        if ($user->hasVerifiedEmail()) {
            return redirect('/')->with('success', 'Your email is already verified.');
        }
        
        $user->sendEmailVerificationNotification();
        return back()->with('resent', 'Verification link sent!');
    }
}
