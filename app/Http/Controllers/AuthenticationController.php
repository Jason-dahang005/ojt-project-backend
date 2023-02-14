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


        if(User::count() == 1){
            $user->assignRole('super-admin');
        }else{
            $user->assignRole('user');
        }

        return $this->sendResponse($user, 'Successfully Registered!');
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success = $user;
            $success['roles'] = $user->roles;
            $success['token'] = $user->createToken('my_token')->accessToken;
            return $this->sendResponse($success, 'Login Succesfully!');
        }else{
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }
    }
}
