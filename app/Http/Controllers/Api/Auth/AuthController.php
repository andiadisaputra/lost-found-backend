<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;
    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService
            ->register($request->validated());

        return response()->json([

            'success'=>true,

            'message'=>'Data berhasil disimpan sementara. Silakan verifikasi OTP untuk membuat akun.',

            'data'=>[
                'name' => $result['pending']->name,
                'email' => $result['pending']->email,
            ],

            /*
            |--------------------------------------------------------
            | DEVELOPMENT ONLY
            |--------------------------------------------------------
            */

            'otp'=>$result['otp']

        ],201);
    }
    public function verifyOtp(
    VerifyOtpRequest $request
): JsonResponse
{
    try {

        $user = $this->authService
            ->verifyOtp($request->validated());

        $token = $user->createToken('mobile-token')->plainTextToken;

        return response()->json([

            'success'=>true,

            'message'=>'OTP berhasil diverifikasi. Akun berhasil dibuat.',

            'token'=>$token,

            'data'=>new UserResource($user),

        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 422);

    }
}
public function login(LoginRequest $request): JsonResponse
{
    try {

        $result = $this->authService->login(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'token'   => $result['token'],
            'data'    => new UserResource($result['user']),
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 401);

    }
}
public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return $this->success('Logout berhasil.');
}

public function resendOtp(Request $request): JsonResponse
{
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    try {
        $otp = $this->authService->resendOtp($request->email);

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP baru telah dikirim.',
            'otp' => $otp, // DEVELOPMENT ONLY
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 422);
    }
}
}