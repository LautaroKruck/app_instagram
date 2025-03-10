<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Chore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

    // Verifica si el usuario existe
    $user = User::where('email', $request->get('email'))->first();

    if (!$user) {
        // Si no existe el usuario
        $validator->errors()->add('credentials', 'El usuario no existe.');
        return redirect()->route('login')->withErrors($validator)->withInput();
    }

    // Verifica las credenciales del usuario
    $credentials = [
        'email' => $user->email,
        'password' => $request->get('password'),
    ];

    // Si las credenciales son correctas, inicia sesión
    if (Auth::attempt($credentials)) {
        // Regenera la sesión para evitar ataques de secuestro de sesión
        $request->session()->regenerate();

        // Redirige a la página principal después de iniciar sesión
        return redirect()->route('posts.home');
    } else {
        // Si las credenciales son incorrectas
        $validator->errors()->add('credentials', 'Credenciales incorrectas');
        return redirect()->route('login')->withErrors($validator)->withInput();
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

    // Permite al usuario agregar una imagen de perfil
    public function addImage(Request $request) {
        $user = Auth::user();

        // Valida la imagen de entrada
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'image.required' => 'El campo de imagen es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo jpeg, png, jpg o gif.',
            'image.max' => 'La imagen no puede tener más de 2MB.',
        ]);

        // Si la validación falla, redirige con errores
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // Si el usuario ya tiene una imagen, la eliminamos
        if ($user->image) {
            Storage::delete($user->image);
        }

        // Guarda la imagen en el sistema de archivos
        $image = $request->file('image')->store('profiles');

        // Actualiza la ruta de la imagen en el perfil del usuario
        $user->image = $image;
        $user->save();

        return redirect()->route('user.profile', ['id' => $user->id])->with('success', 'Imagen de perfil actualizada correctamente.');
    }

    // Permite al usuario eliminar su propio perfil y todos sus posts
    public function deleteUser() {
        $user = Auth::user();
    
        if ($user) {
            // Elimina las sesiones asociadas al usuario eliminado
            DB::table('sessions')->where('user_id', $user->id)->delete();
    
            // Elimina el usuario y sus posts y comentarios
            $user->delete();
    
            // Cierra la sesión del usuario
            Auth::logout();
    
            // Borra todos los datos de la sesión para evitar el problema de "usuario eliminado"
            session()->invalidate();
            session()->regenerateToken();
    
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
