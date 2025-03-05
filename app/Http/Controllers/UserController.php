<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Chore;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Muestra la vista del perfil del usuario, incluyendo las tareas asociadas
    public function showUser($id) {
        $user = User::find($id);
        return view('user_views.profile', compact('user'));
    }

    // Muestra el formulario de inicio de sesión
    public function showLogin() {
        return view('user_views.login'); // Carga la vista de inicio de sesión
    }

    // Procesa el inicio de sesión del usuario
    public function doLogin(Request $request) {
        // Valida los datos de entrada
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'El campo de correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'password.required' => 'El campo de contraseña es obligatorio.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
        ]);

        // Si la validación falla, redirige con errores
        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        // Verifica las credenciales del usuario
        $userEmail = $request->get('email');
        $userPassword = $request->get('password');
        $user = User::where('email', $userEmail)->first();
        if (!password_verify($userPassword, $user->password)) {
            $validator->errors()->add('credentials', 'Credenciales incorrectas');
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        // Si las credenciales son válidas, inicia sesión y carga la vista principal del usuario
        $credentials = [
            'email' => $user->email,
            'password' => $userPassword,
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $request->session()->put('user', $user);
            return redirect()->route('posts.home'); // Carga la vista principal con la información del usuario
        }
    }

    // Muestra el formulario de registro de usuario
    public function showRegister() {
        return view('user_views.register'); // Carga la vista de registro
    }

    // Procesa el registro de un nuevo usuario
    public function doRegister(Request $request) {
        // Valida los datos de entrada para el registro
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:6',
                'max:20',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'password_repeat' => 'required|same:password',
        ], [
            'name.required' => 'El campo de nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 20 caracteres.',
            'email.required' => 'El campo de correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'El campo de contraseña es obligatorio.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.max' => 'La contraseña no puede tener más de 20 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una minúscula, una mayúscula y un dígito.',
            'password_repeat.required' => 'El campo de repetir contraseña es obligatorio.',
            'password_repeat.same' => 'Las contraseñas no coinciden.',
        ]);

        // Si la validación falla, redirige con errores
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        // Crea un nuevo usuario y lo guarda en la base de datos
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login'); // Redirige a la vista de inicio de sesión
    }

    // Permite al usuario eliminar su propio perfil y todos sus posts
    public function deleteUser() {
        $user = Auth::user();
    
        if ($user) {
            // Elimina el usuario y automáticamente se eliminan sus posts y comentarios
            $user->delete();
    
            // Cierra la sesión del usuario
            Auth::logout();
    
            // Redirige a la vista de inicio de sesión con un mensaje de éxito
            return redirect()->route('login')->with('success', 'Tu perfil ha sido eliminado correctamente.');
        }
    
        return redirect()->route('login')->withErrors('No se pudo eliminar el perfil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // Redirigir a login después del logout
    }
    
}
