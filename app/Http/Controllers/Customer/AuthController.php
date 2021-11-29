<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\userAuth;
use App\Http\Requests\userLoginAuth;
use App\Serializers\userRegisterSerializer;
use App\Serializers\userLoginSerializer;
use App\Models\User;

class AuthController extends Controller
{
    use userRegisterSerializer, userLoginSerializer;

    public function Register(userAuth $request)
    {
        $validated = $request->validated();
        $final_data = $this->process($validated);
        $user = User::create($final_data);
        $token = $user->createToken('myappToken')->plainTextToken;
        $response = ["status" => "success", 'user' => $user, 'token' => $token];
        return response($response, 200);
    }
    public function getCustomer()
    {
        return auth()->user();
    }
    public function login(userLoginAuth $request)
    {
        $validated = $request->validated();
        $final_data = $this->loginprocess($validated);

        $user = User::where('email', $final_data['email']);
        if ($user->count() > 0) {
            $user = $user->first();
            if (!$user || !Hash::check($final_data['password'], $user->password)) {
                $response = ["status" => "failed", "msg" => "Incorrect Credentials"];
                return response($response, 401);
            }
            $token = $user->createToken('userToken')->plainTextToken;
            $response = ["status" => "success", 'user' => $user, 'token' => $token];
            return response($response, 200);
        } else {
            $response = ["status" => "failed", "msg" => "Please Enter Valid Email"];
            return response($response, 401);
        }
    }
    public function countCustomer()
    {
        $data = User::count();
        return response()->json(array("status" => 200, "data" => $data));
    }
    public function logout(Request $request)
    {

        auth('users')->user()->tokens()->delete();
        return ['message' => "Customer Logged Out"];
    }
}
