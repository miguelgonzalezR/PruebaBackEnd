<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\models\User;
use \stdClass;  
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{

    // ver los usuarios de la base
    public function index()
    {
        $user = User::all();

        return response()->json($user);
    }

    // Mostrar un usuario específico
    public function VerPro($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return response()->json($user);
    }
    
    // Funcion para registrar usuarios
    public function registrar(Request $request)
    {

        // Verificar si ya existe al menos un usuario
        $userCount = User::count();

        // Si hay usuarios, requerir autenticación
        if ($userCount > 0) {
            if (!Auth::check()) {
                return response()->json(['message' => 'Debe iniciar sesión para registrar un usuario'], 401);
            }
        }

        // valida los datos enviados
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'sexo' => 'required|string|max:20',
            'area' => 'required|string|max:255',
            'rol' => 'required|string|max:255',
        ]);

        // muestra mensaje de error si los campos no cumplen los requisitos
        if($validator->fails()){
            return response()->json($validator->errors());
        }

        // crea el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'apellido' => $request->apellido,
            'password' => Hash::make($request->password),
            'sexo' => $request->sexo,
            'area' => $request->area,
            'rol' => $request->rol,

        ]);

        // Crea un token de autentificacion 
        $token = $user->createToken('auth_token')->plainTextToken;

        return response() -> json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer']);

    }


    // Funcion para actualizar usuarios

    public function EditarUser(Request $request, $id){

        // Validar los datos de entrada
         $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|max:255|unique:users,email,' . $id,
            'sexo' => 'sometimes|string|max:20',
            'area' => 'sometimes|string|max:255',
            'rol' => 'sometimes|string|max:255',
        ]);

        // Retornar errores si la validación falla
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // Encontrar el usuario por ID
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Actualizar los campos que se han proporcionado
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'apellido' => $request->apellido,
            'sexo' => $request->sexo,
            'area' => $request->area,
            'rol' => $request->rol,
        ]);

        return response()->json(['message' => 'Usuario actualizado con éxito', 'user' => $user]);

    }


    public function EliminarUser($id)
    {
        // Encontrar el usuario por ID
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Eliminar el usuario
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado con éxito']);
    }


    // Funcion de inicio de session

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password')))
        {
            return response() -> json(['message' => 'Credinciales no validas'], 401);
        }

        $user = User::where('email', $request['email']) -> firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response() -> json ([

            'message' => 'Hola ' .$user->name,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,

        ]);
    }


    public function checkUsers()
    {
        $userCount = User::count();

        return response()->json(['hasUsers' => $userCount > 0]);
    }


    // Funcion para cerrar session

    public function logout()
    {

        auth()->user()->tokens()->delete();

        return [
            'message' => 'Se a cerrado la session'
        ];

    }

}
