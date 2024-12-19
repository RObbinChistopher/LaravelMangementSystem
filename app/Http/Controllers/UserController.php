<?php

namespace App\Http\Controllers;

use App\Http\Resources\userResource;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ImageUploadTrait;

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;

            return response()->json([
                'user' => new userResource($user),
                'token' => $token
            ]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    public function getAllUser(Request $request)
    {
        $users = User::where('role', '!=', 'admin')->get();  // Corrected comparison
        return userResource::collection($users);
    }

    public function allUser(Request $request)
    {
        $users = User::paginate(10);
        return userResource::collection($users);
    }

    public function createUser(Request $request)
    {
        $user = new User();

        $user->email = $request->email;
        $user->name = $request->name;
        $user->role = $request->role;
        $user->password =  Hash::make($request->password);
        $user->save();
        return response()->json(['user' => new userResource($user), 'token' => $user->createToken('MyApp')->accessToken]);
    }

    public function EditUser(string $id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }
    public function UpdateUser(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $user->email = $request->email;
        $user->name = $request->name;
        $user->role = $request->role;
        $user->save();
        return response()->json(['user' => new userResource($user)]);
    }
    public function deleteUser(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['user' => 'User Delete Successfully']);
    }

    public function FilterOfRole(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($request->role) {
            $user->role = $request->role;
        }
        $user->save();
        return response()->json(['user' => 'User Role Update Successfully']);
    }

    public function userSearch(Request $request)
    {
        $query = $request->input('query');

        $results = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->limit(5)
            ->get();

        return UserResource::collection($results);
    }

    public function FilterByStatus(string $role)
    {
        $user = User::where('role', $role)->paginate(10);
        return UserResource::collection($user);
    }

    public function loginUser()
    {
        $user = Auth::user();

        return new UserResource($user);
    }
    public function ProfileUpdateUser(Request $request)
    {
        $user = Auth::user();

        $image = $this->Updateimage($request, 'image', 'profile', $user->profile);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->profile = $image;

        $user->save();

        return response()->json(['user' => 'User Profile Update Successfully', $user]);
    }
    
    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();
        if ($request->password){
            $user->password = Hash::make($request->password);
            $user->update();
            return response()->json(['success' => 'Successfully Updated']);
        }
    }

}
