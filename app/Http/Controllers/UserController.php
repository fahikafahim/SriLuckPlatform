<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Get all users (API endpoint)
     *
     * Retrieves a collection of all users in the system.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *   Returns a collection of users wrapped in UserResource
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Create a new user (API endpoint)
     *
     * Validates and stores a new user record with hashed password.
     *
     * @param Request $request HTTP request containing user data
     * @return UserResource
     *   Returns the newly created user wrapped in UserResource
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'user_type'=> 'nullable|string',
        ]);

        // Hash the password before storing
        $validated['password'] = bcrypt($validated['password']);

        // Create and return new user
        $user = User::create($validated);
        return new UserResource($user);
    }

    /**
     * Get specific user details (API endpoint)
     *
     * Retrieves details for a single user by ID.
     *
     * @param User $user User model instance (route model binding)
     * @return UserResource
     *   Returns the requested user wrapped in UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update user information (API endpoint)
     *
     * Validates and updates user record. Password is hashed if provided.
     *
     * @param Request $request HTTP request containing update data
     * @param User $user User model instance to update
     * @return UserResource
     *   Returns the updated user wrapped in UserResource
     */
    public function update(Request $request, User $user)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6',
            'user_type'=> 'nullable|string',
        ]);

        // Hash the password if it was provided in the update
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        // Update and return the user
        $user->update($validated);
        return new UserResource($user);
    }

    /**
     * Delete a user (API endpoint)
     *
     * Permanently removes a user from the system.
     *
     * @param User $user User model instance to delete
     * @return \Illuminate\Http\JsonResponse
     *   Returns JSON response with deletion confirmation
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
