<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RecoverRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\Auth\ResetPassword;
use App\Notifications\Auth\UserRegister;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;

/**
 * AuthController controller authentication process
 */
class AuthController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware(
            'register',
            ['only' => ['register']]
        );
        $this->middleware(
            'auth:sanctum',
            ['except' => ['login', 'register', 'recover', 'reset', 'verify']]
        );
        $this->middleware(
            'demo',
            ['only' => ['register', 'recover', 'reset']]
        );
        $this->middleware(
            'captcha',
            ['only' => ['login', 'register', 'recover', 'reset']]
        );
    }

    /**
     * Perform login operation
     *
     * @param LoginRequest $request request`
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(
                ['message' => __('These credentials do not match, or the user is disabled')],
                406
            );
        }

        $user = Auth::user();

        if ((int) $user->status !== 1) {
            return response()->json(
                ['message' => __('The user is deactivated')],
                406
            );
        }
        $token = $user->createToken(Str::slug(config('app.name') . '_auth_token', '_'))
            ->plainTextToken;

        return response()->json(
            ['token' => $token, 'user' => new UserResource($user)]
        );
    }

    /**
     * User logout and delete user access token
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json(['message' => __('Session closed successfully')]);
    }

    /**
     * New user registration
     *
     * @param RegisterRequest $request request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['password'] = bcrypt($request->password);
        $validated['role_id'] = $this->master()->app_default_role;

        $user = User::create($validated);
        $user->notify((new UserRegister())->locale($this->master()->app_locale));

        $token = $user->createToken(Str::slug(config('app.name') . '_auth_token', '_'))
            ->plainTextToken;

        return response()->json(
            ['token' => $token, 'user' => new UserResource($user)]
        );
    }

    /**
     * Password recover process
     *
     * @param RecoverRequest $request request
     *
     * @return JsonResponse
     */
    public function recover(RecoverRequest $request): JsonResponse
    {
        $request->validated();

        $user = User::where('email', $request->get('email'))->first();

        if (!$user) {
            return response()->json(
                ['message' => __('The email entered is not registered')],
                406
            );
        }

        $token = Str::random(60);

        DB::table('password_resets')->where('email', $request->email)->delete();

        DB::table('password_resets')->insert(
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        $user->notify((new ResetPassword($token)));

        return response()->json(
            ['message' => __('An email has been sent with the password reset link')]
        );
    }

    /**
     * Password resetting
     *
     * @param ResetRequest $request request
     *
     * @return JsonResponse
     */
    public function reset(ResetRequest $request): JsonResponse
    {
        $request->validated();

        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->first();

        if (!$tokenData) {
            return response()->json(
                ['message' => __('The recovery token is incorrect try again')],
                406
            );
        }

        $user = User::where('email', $tokenData->email)->first();

        if (!$user) {
            return response()->json(
                ['message' => __('The email entered is not registered')],
                406
            );
        }

        $user->password = bcrypt($request->get('password'));

        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = Carbon::now();
        }

        $user->save();

        DB::table('password_resets')->where('email', $user->email)->delete();

        $user = Auth::loginUsingId($user->id);

        $token = $user->createToken(
            Str::slug(config('app.name') . '_auth_token', '_')
        )->plainTextToken;

        return response()->json(
            [
                'token' => $token,
                'user' => new UserResource($user),
                'message' => __('Password updated successfully'),
            ]
        );
    }

    /**
     * Authorized user
     *
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        return response()->json(new UserResource(auth()->user()));
    }

    /**
     * Checks user is valid and has permission to perform action
     *
     * @param Request $request request
     *
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        $access = false;
        $authorized = Auth::check();

        if (!$authorized) {
            return response()->json(
                [
                    'authorized' => $authorized,
                    'gate_pass' => $access,
                ]
            );
        }

        $user = Auth::user();
        if ($request->get('gate')) {
            $access = $user->userRole->checkPermission($request->get('gate'));
        }

        return response()->json(
            [
                'authorized' => $authorized,
                'gate_pass' => $access,
            ]
        );
    }
}
