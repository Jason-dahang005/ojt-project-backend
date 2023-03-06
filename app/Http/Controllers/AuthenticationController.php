<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticationController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'email'             => 'required|email',
            'password'          => 'required|min:5'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $user->assignRole('user');

        return response()->json([
            'message'       => 'Registered Successfully!',
            'user'          => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credential = $request->only('email', 'password');

        if(Auth::guard('web')->attempt($credential)){
            $user = User::query()->where('email', $request['email'])->first();
            $role = $user->roles;
            $token= $user->createToken('personal_access_token')->accessToken;

            return response()->json([
                'message'       => 'Logged in Successfully!',
                'user'          => $user,
                'token'         => $token
            ], 200);

            //return $this->sendResponse($success, 'Login Succesfully!');
        }else{
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'message'   => 'Logged out successfully!'
        ]);
    }
}
