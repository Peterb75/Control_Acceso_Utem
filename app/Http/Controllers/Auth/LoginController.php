<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User\Users;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Num_Iden' => ['required'],
            'Password' => ['required'],
        ]);

        $user = Users::where('Num_Iden', $credentials['Num_Iden'])->first();

        if ($user && Hash::check($credentials['Password'], $user->Password)) {
            Auth::login($user);
            \Log::info('Usuario logueado correctamente: ' . $user->Num_Iden);
            return $this->redirectBasedOnRole($user);
        } else {
            \Log::warning('Error al loguear: usuario o contraseña incorrectos');
        }

        return back()->withErrors([
            'Num_Iden' => 'La contraseña o el Número de identificación no son correctos',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected function redirectBasedOnRole($user)
    {
        \Log::debug('Redirigiendo según rol: ' . $user->FK_TipoUsuario);

        switch ($user->FK_TipoUsuario) {
            case 1: // Administrador
                return redirect()->route('ListSolInv'); // Vista principal del admin

            case 2: // Alumno
                return redirect()->route('usuario.qr'); // Donde ve y descarga su QR

            case 3: // Docente Tiempo Completo
            case 4: // Docente Medio Tiempo
                return redirect()->route('usuario.qr'); // También pueden usar QR personal

            case 5: // Guardia
                return redirect()->route('guardia.index'); // Donde escanea QRs

            default:
                \Log::error('Rol no reconocido: ' . $user->FK_TipoUsuario);
                return redirect()->route('login')->withErrors(['rol' => 'Tipo de usuario no válido']);
        }
    }

}
