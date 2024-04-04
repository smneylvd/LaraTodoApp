<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'unique:users|email|required',
            'name' => 'required',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'repassword' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            throw new HttpException(400, $validator->errors()->first());
        }

        $newUser = new User();
        $newUser->email = $request->get('email');
        $newUser->name = $request->get('name');
        $newUser->password = bcrypt($request->get('password'));
        $newUser->created_at = Carbon::now();
        $newUser->updated_at = Carbon::now();
        $newUser->save();

        return $this->respondWithToken($newUser->createToken('app')->plainTextToken);
    }

    public function profile(Request $request)
    {
        return Auth::user();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new HttpException(400, $validator->errors()->first());
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(["error" => "Incorrect credentials"], 401);
        }

        $user = Auth::user();
        return $this->respondWithToken($user->createToken('app')->plainTextToken);
    }


    public function logout(Request $request)
    {
        $item = Auth::user();
        $item->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }


    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }
}
