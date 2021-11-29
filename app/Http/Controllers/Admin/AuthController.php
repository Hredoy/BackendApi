<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\adminRegisterAuth;
use App\Http\Requests\adminLoginAuth;
use App\Serializers\adminRegisterSerializer;
use App\Serializers\adminLoginSerializer;
use App\Models\Admin;

class AuthController extends Controller
{
    use adminRegisterSerializer, adminLoginSerializer;

    public function Register(adminRegisterAuth $request)
    {
        $validated = $request->validated();
        $final_data = $this->process($validated);
        $admin = Admin::create($final_data);
        $token = $admin->createToken('adminToken')->plainTextToken;
        $response = ['admin' => $admin, 'token' => $token];
        return response($response, 200);
    }
    public function login(adminLoginAuth $request)
    {
        $validated = $request->validated();
        $final_data = $this->loginprocess($validated);

        $admin = Admin::where('email', $final_data['email']);
        if ($admin->count() > 0) {
            $admin = $admin->first();
            if (!$admin || !Hash::check($final_data['password'], $admin->password)) {
                $response = ["status" => "failed", "msg" => "Incorrect Credentials"];
                return response($response, 401);
            }
            $token = $admin->createToken('adminToken')->plainTextToken;
            $response = ["status" => "success", 'admin' => $admin, 'token' => $token];
            return response($response, 200);
        } else {
            $response = ["status" => "failed", "msg" => "Please Enter Valid Email"];
            return response($response, 401);
        }
    }
    public function logout(Request $request)
    {

        auth('admins')->user()->tokens()->delete();
        return ['message' => "Admin Logged Out"];
    }
}
