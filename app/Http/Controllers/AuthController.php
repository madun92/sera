<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function register(Request $request) 
    {
        $this->validate($request, [
            "username" => "required|min:5",
            "email" => "required|unique:users",
            "password" => "required|min:6",
        ]);

        $user = User::create([
            "username" => $request->username,
            "email" => $request->email,
            "password" => app('hash')->make($request->password),
        ]);

        return $this->responseJson(false, $user);
    }

    /**
     * Login
     *
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     operationId="login",
     *     @OA\Parameter(
     *       name="email",
     *       in="query",
     *       description="Email address of the user ",
     *       required=true,
     *       example="admin@gmail.com",
     *       @OA\Schema(
     *         type="string",
     *       ),
     *     ),
     *     @OA\Parameter(
     *       name="password",
     *       in="query",
     *       description="Password ",
     *       required=true,
     *       @OA\Schema(
     *         type="string",
     *       ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="post not found"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="ok",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="error",
     *                         type="string",
     *                         description="The response code"
     *                     ),
     *                     @OA\Property(
     *                         property="message",
     *                         type="string",
     *                         description="The response message"
     *                     ),
     *                     @OA\Property(
     *                         property="data",
     *                         type="array",
     *                         description="The response data",
     *                         @OA\Items
     *                     ),
     *                     example={
     *                         "error": false,
     *                         "message": "Success",
     *                         "data": {}
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     * )
     */
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            "email" => "required|exists:users",
            "password" => "required",
        ]);

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            throw new UnauthorizedException("Invalid Login", 200);
        }

        return $this->responseJson(false, $this->respondWithToken($token));
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->responseJson(false, ["user" => auth()->user()]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return $this->responseJson(false, [], 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * check Login
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkLogin(Request $request)
    {
        // dd($request->header('authorization'));
        $token = $this->validate($request, [
            "token" => 'required'
        ]);
        $user = JWTAuth::setToken($token)->toUser();
        if($user == null){
            abort(401);
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        // return response()->json([
        //     'access_token' => $token,
        //     'token_type' => 'bearer',
        //     'expires_in' => auth()->factory()->getTTL() * 60
        // ]);
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    //
}
