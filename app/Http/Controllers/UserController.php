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
    public function showUser($id) {
        $user = User::find($id);
        $chores = $user->chores()->get();
        return view('user_views.index', compact('chores', 'user'));
    }
    //Show login form
    public function showLogin() {
        return view('user_views.login'); // CARGA LA VIEW DE LOGIN PARA PODER REALIZAR LOGIN
    }

    //Do login
    public function doLogin(Request $request) {
        // VALIDAR DATOS DE ENTRADA
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'El campo de correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'password.required' => 'El campo de contraseña es obligatorio.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
        ]);

        // SI LOS DATOS SON INVÁLIDOS, DEVOLVER A LA PÁGINA ANTERIOR E IMPRIMIR LOS ERRORES DE VALIDACIÓN
        if ($validator->fails()) {
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        // SI EL LOGIN ES INCORRECTO, DEVOLVER A LA PÁGINA ANTERIOR E IMPRIMIR LOS ERRORES DE VALIDACIÓN
        $userEmail = $request->get('email');
        $userPassword = $request->get('password');
        $user = User::where('email', $userEmail)->first();
        if(!password_verify($userPassword, $user->password)) {
            $validator->errors()->add('credentials', 'Credenciales incorrectas');
            return redirect()->route('login')->withErrors($validator)->withInput();
        }

        // SI LOS DATOS SON VÁLIDOS (SI EL LOGIN ES CORRECTO) CARGAR LA VISTA PRINCIPAL DEL USUARIO.

        $credentials = [
            'email' => $user->email,
            'password' => $userPassword,
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $posts = $user->posts()->get();
            return view('user_views.index', compact('posts', 'user')); // CARGA LA VIEW PRINCIPAL CON LA INFO DEL USUARIO

        }
        
    }

    //Show register form
    public function showRegister() {
        return view('user_views.register'); // CARGA LA VIEW DE REGISTER PARA PODER REALIZAR UN ALTA DE USUARIO
    }

    //Do register
    public function doRegister(Request $request) {

        // VALIDAR DATOS DE ENTRADA. LAS REGLAS DE VALIDACIÓN SON LAS SIGUIENTES:
        /*
            -> nombre es obligatorio, debe ser un string y debe ser menor de 20 carácteres
            -> email es obligatorio, debe seguir un formato estándar, debe ser único en la base de datos
            -> password es obligatoria, debe ser mayor de 5 carácteres, menor de 20 carácteres, debe contener una minúscula, una mayúscula y al menos un dígito
            -> password_repeat es obligatoria y debe ser igual a password
        */
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

        // SI LOS DATOS SON INVÁLIDOS, DEVOLVER A LA PÁGINA ANTERIOR E IMPRIMIR LOS ERRORES DE VALIDACIÓN
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();


        // SI LOS DATOS SON VÁLIDOS (SI EL REGISTRO SE HA REALIZADO CORRECTAMENTE) CARGAR LA VIEW DE LOGIN PARA PODER REALIZAR LOGIN

        return redirect()->route('login'); // CARGA LA VIEW DE LOGIN PARA PODER REALIZAR LOGIN
    }
}
