<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\{User,UserIntranet};
use Illuminate\Http\Request;
use App\Traits\ApiController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiController;

    // 1. Registro de usuarios
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max|255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Creamos el token inmediatamente después de registrarse
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 21);
    }

    // 2. Login de usuarios
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Validamos que el usuario exista y la contraseña sea correcta
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        // Revocar tokens anteriores si quieres un solo dispositivo (Opcional)
        // $user->tokens()->delete();

        // Creamos el nuevo token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
        ]);
    }


    public function loginByIntranet(Request $request, $user_id, $token  )
    {
        
        $response = $this->curlIntranet($token);
        if(array_key_exists('user', $response)){
            if($response['user']->id == $user_id) {
                \Log::info(serialize($response['user']));
                $user = $this->storeUser($response['user']);

                $token = $user->createToken($user->id)->plainTextToken;

                return response()->json([
                    'access_token' => $token,
                    'user' => $user,
                    'token_type' => 'bearer',
                ]);
            
            }else{
                return response()->json(['data' => 'Authorization is not valid'], 401);
            }
        }else{
            return response()->json(['data' => 'Authorization is not valid'], 401);
        }
    }

    public function storeUser($user_intranet)
    {
        $user = User::where('user_intranet_id',$user_intranet->id)->first();

        if (is_null($user)) {
            $user = new User;
            $user->firstname = $user_intranet->firstname;
            $user->lastname = $user_intranet->lastname;
            $user->email = $user_intranet->email;
            $user->phone = $user_intranet->phone;
            $user->photo = $user_intranet->photo;
            $user->birthday = $user_intranet->birthday;
            $user->password = Hash::make('CLAVE_SECRETA');
            $user->user_intranet_id = $user_intranet->id;
            $user->save();
        }
        return $user;
    }

    // 3. Logout (Revocar Token)
    public function logout(Request $request)
    {
        // Elimina el token actual con el que el usuario se autenticó
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente y token eliminado.'
        ]);
    }
}