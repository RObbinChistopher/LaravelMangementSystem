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
        $users = User::where('position', '!=', 'Affiliate')->paginate(10);
        return userResource::collection($users);
    }


    public function createUser(Request $request)
    {
        $user = new User();

        // Get first character of first name and last name
        $firstChar = strtoupper(substr($request->name, 0, 1)); // First letter of first name
        $lastChar = strtoupper(substr($request->last_name, 0, 1)); // First letter of last name

        // Ensure unique referral ID
        do {
            $uniqueId = $firstChar . mt_rand(100000, 999999) . $lastChar;
        } while (User::where('referral_id', $uniqueId)->exists());

        // Assign user properties
        $user->email = $request->email;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->position = $request->position;
        $user->referral_id = $uniqueId;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken('MyApp')->accessToken
        ]);
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
        $user->last_name = $request->last_name;
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->position = $request->position;
        $user->password = Hash::make($request->password);
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
            ->orWhere('referral_id', 'like', "%$query%")
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
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->bank_name = $request->bank_name;
        $user->account_title = $request->account_title;
        $user->account_number = $request->account_number;
        $user->profile = $image;

        $user->save();

        return response()->json(['user' => 'User Profile Update Successfully', $user]);
    }

    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->update();
            return response()->json(['success' => 'Successfully Updated']);
        }
    }

    // affiliate

    public function showAgent()
    {
        $user = User::where('position', 'Affiliate')->paginate(10);
        return userResource::collection($user);
    }
}
