<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{

    public function index(Request $request): AnonymousResourceCollection
    {
        $query = User::query();

//        Filter name
        if($name = $request->get('name', '')){
            $query->where('name', 'like', "%$name%");
        }

//        Filter email
        if($email = $request->get('email', '')){
            $query->where('email', 'like', "%$email%");
        }

//        orderBy
        if($orderBy = $request->get('sortBy')){
            $sortDesct = $request->get('sortDesc', 'false');
            if($sortDesct === 'true'){
                $query->orderBy($orderBy, 'desc');
            } else{
                $query->orderBy($orderBy);
            }
        } else{
            $query->orderBy('id');
        }

//        pagination
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
//        Can't delete himself
        if($user->id !== Auth::user()->id){
            $user->delete();

            return response()->json([
                'message' => 'Successfully deleted user!'
            ]);
        } else{
            return response()->json([
                'message' => "You can't do this action!"
            ], 403);
        }
    }

    /**
     * This role can assign and revoke the 'Admin' role
     */
    public function changeAdminRole(User $user): JsonResponse
    {
//        Can't change role to himself
        if($user->id !== Auth::user()->id){

            if($user->hasRole('Admin')){

                $user->removeRole('Admin');
                return response()->json([
                    'message' => 'Successfully revoked Admin role to user!'
                ]);

            } else{

                $user->assignRole('Admin');
                return response()->json([
                    'message' => 'Successfully assigned Admin role to user!'
                ]);

            }

        } else{
            return response()->json([
                'message' => "You can't do this action!"
            ], 403);
        }
    }

}
