<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\AccountDetailsRequest;
use App\Http\Requests\AccountPasswordRequest;
use App\Http\Resources\UserResource;
use Auth;
use Hash;
use Illuminate\Http\JsonResponse;

/**
 * Manage user account and password
 */
class AccountController extends ApiController
{
    /**
     * Construct middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo');
    }

    /**
     * User account information update
     *
     * @param DetailsRequest $request request
     *
     * @return JsonResponse
     */
    public function update(AccountDetailsRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user      = Auth::user();

        if ($request->email !== $user->email) {
            $validated['email']             = $request->email;
            $validated['email_verified_at'] = null;
        }

        if ($request->file('avatar')) {
            $validated['avatar'] = $request->file('avatar')
                ->store('avatar', 'public');
        } elseif ('true' === $request->gravatar) {
            $user->avatar = null;
        }

        $user->update($validated);
        return response()->json(
            [
                'message' => __('Data saved successfully'),
                'user'    => new UserResource($user),
            ]
        );
    }

    /**
     * Password reset handling
     *
     * @param PasswordRequest $request request
     *
     * @return JsonResponse
     */
    public function password(AccountPasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user      = Auth::user();

        if (!(Hash::check($request->current_password, $user->password))) {
            return response()->json(
                [
                    'message' => __('The password does not match the password'),
                ],
                406
            );
        }

        if (strcmp($request->current_password, $request->password) === 0) {
            return response()->json(
                ['message' => __('The new password can not be the previous')],
                406
            );
        }

        $validated['password'] = bcrypt($request->password);

        $user->update($validated);
        return response()->json(
            ['message' => __('Password changed successfully')]
        );
    }
}
