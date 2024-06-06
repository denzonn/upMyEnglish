<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken($user->name)->accessToken;

            $response = [
                'token' => $token,
                'id' => $user->id,
                'roles' => $user->roles,
                'email' => $user->email,
            ];

            return $this->sendResponse($response, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' =>'required',
            'email' =>'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $input = $request->all();
        $input['password'] =  bcrypt($input['password']);
        $input['roles'] = 'USER';
        $user = User::create($input);

        $success['token'] =  $user->createToken($input['name'])->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }
}
