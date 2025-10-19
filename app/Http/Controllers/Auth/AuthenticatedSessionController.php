<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // --- INICIO DE LA MODIFICACIÓN ---
        
        // Revisamos si el usuario que acaba de iniciar sesión está activo
        if (Auth::user()->is_active == false) {
            
            // Si no está activo (is_active es false):
            // 1. Cerramos la sesión que se acababa de crear.
            Auth::guard('web')->logout();

            // 2. Invalidamos la sesión.
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // 3. Lo devolvemos al login con un mensaje de error específico.
            return redirect()->route('login')->withErrors([
                'email' => 'Esta cuenta ha sido deshabilitada. Contacta al administrador.',
            ]);
        }

        // --- FIN DE LA MODIFICACIÓN ---

        // Si SÍ está activo, simplemente sigue con el proceso normal.
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
