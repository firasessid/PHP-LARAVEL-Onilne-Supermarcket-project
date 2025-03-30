<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use PragmaRX\Google2FAQRCode\Google2FA as Google2FAQRCode; // Import avec alias
use Illuminate\Support\Facades\Session;
use App\Models\UserSession;

class AccountController extends Controller
{
    /**
     * Setup Two-Factor Authentication (Generate QR Code and Secret Key).
     */
    // MODIFIED setup() METHOD

    public function setup()
    {
        $user = Auth::user()->fresh();
        $google2faQrCode = new Google2FAQRCode();
    
        // Always get sessions regardless of 2FA status
        $sessions = UserSession::where('user_id', $user->id)
            ->orderBy('login_time', 'desc')
            ->get();
    
        $activeSessions = $sessions->filter(function ($session) {
            return $session->action_type !== 'logout';
        });
    
        $latestSession = $activeSessions->first();
    
        if ($user->google2fa_secret) {
            $qrCode = $google2faQrCode->getQRCodeInline(
                config('app.name'),
                $user->email,
                $user->google2fa_secret
            );
    
            return view('Back-end.settings', [
                'qrCode' => $qrCode,
                'secretKey' => $user->google2fa_secret,
                'latestSession' => $latestSession // Always include
            ]);
        }
    
        // Include latestSession even when no 2FA secret exists
        return view('Back-end.settings', [
            'qrCode' => null,
            'secretKey' => null,
            'latestSession' => $latestSession // Add this line
        ]);
    }
// NEW METHOD TO GENERATE SECRET
public function generateSecret(Request $request)
{
    $user = Auth::user()->fresh();
    $google2fa = new Google2FA();

    // Generate and save new secret
    $user->google2fa_secret = $google2fa->generateSecretKey();
    $user->save();

    // Redirect back to setup page
    return redirect()->route('2fa.setup');
}    /**
     * Enable Two-Factor Authentication (Validate OTP).
     */
    public function enable(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        $google2fa = new Google2FA();
        $google2fa->setWindow(1); // Strict time window (±1 period)

        $user = Auth::user();

        // Validate the OTP
        if ($google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            Session::put('2fa_verified', true); // Mark 2FA as verified
            return redirect()->route('dashboard')->with('success', '2FA activé avec succès.');
        }

        return redirect()->back()->withErrors(['code' => 'Code de vérification incorrect.']);
    }

    /**
     * Disable Two-Factor Authentication.
     */
    public function disable(Request $request)
    {
        $request->validate(['password' => 'required|string']);
    
        $user = Auth::user();
    
        if (!\Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Mot de passe incorrect.']);
        }
    
        // Désactiver le 2FA
        $user->google2fa_secret = null;
        $user->save();
    
        // Effacer la session 2FA
        Session::forget('2fa_verified');
        
        return redirect()->route('2fa.setup')->with('success', '2FA désactivé avec succès.');
    }
    
/**
     * Show the verification form for 2FA.
     */
    public function showVerifyForm()
    {
        return view('Back-end.verify');
    }

    /**
     * Verify the OTP during login or protected route access.
     */
    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);
    
        $google2fa = new Google2FA();
        $user = Auth::user();
    
        if ($google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            session(['2fa_verified' => true]);
            return redirect()->route('dashboard');
        }
    
        // Retour avec erreur liée au champ 'code'
        return back()->withErrors(['code' => 'Code de vérification incorrect.']);
    }}