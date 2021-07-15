<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if($name = $request->get('name', '')){
            $query->where('name', 'like', "%$name%");
        }

        if($email = $request->get('email', '')){
            $query->where('email', 'like', "%$email%");
        }

        if($orderBy = $request->get('sortBy')){
            $sortDesct = $request->get('sortDesc', 'false');
            if($sortDesct === 'true'){
                $query->orderBy($orderBy, 'desc');
            } else{
                $query->orderBy($orderBy);
            }
        } else{
            $query->orderBy('id', 'desc');
        }

        if($request->get('page', '')){
            $perPage = $request->get('perPage', 10);
            $users = $query->paginate($perPage);
        } else {
            $users = $query->get();
        }

        return UserResource::collection($users);
    }

    public function store(UserRequest $request): JsonResponse
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function update(User $user, UserRequest $request): JsonResponse
    {
        $user->update($request->all());

        if($request->password){
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return response()->json([
            'message' => 'Successfully updated user!'
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'Successfully deleted user!'
        ]);
    }

}
