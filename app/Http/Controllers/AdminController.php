<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // Direct Change Password Page
    public function changePasswordPage() {
        return view('admin.account.changePassword');
    }

    // Change Password
    public function changePassword(Request $request) {
        $this->checkPasswordValidation($request);

        $query = User::select('password')->where('id', Auth::user()->id)->first();
        $dbHashedPassword = $query->password;

        if(Hash::check($request->oldPassword, $dbHashedPassword)) {
            User::find(Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            return back()->with(['changeSuccess' => 'Changed successfully.']);
        }

        return back()->with(['incorrectPassword' => 'The old password is incorrect.']);
    }

    // Direct Detail Page
    public function detailPage() {
        return view('admin.account.detail');
    }

    // Direct Profile Update Page
    public function updatePage() {
        return view('admin.account.update');
    }

    // Profile Update
    public function update(Request $request) {
        $this->checkProfileValidation($request);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        if($request->hasFile('image')) {
            $dbImage = User::find(Auth::user()->id)->image;
            if($dbImage != null) {
                Storage::delete('public/profile/' . $dbImage);
            }

            $imageName = uniqid() . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/profile', $imageName);

            $data['image'] = $imageName;
        }

        User::find(Auth::user()->id)->update($data);

        return redirect()->route('admin#detailPage')->with(['updateSuccess' => 'Profile updated successfully.']);
    }

    // Direct Admin List Page
    public function list() {
        $admins = User::when(request('searchKey'), function($query) {
            $query->orWhere('name', 'like', '%' . request('searchKey') . '%')
                ->orWhere('email', 'like', '%' . request('searchKey') . '%')
                ->orWhere('address', 'like', '%' . request('searchKey') . '%')
                ->orWhere('phone', 'like', '%' . request('searchKey') . '%');
        })
            ->where('role', 'admin')
            ->paginate(3);

        $admins->appends(request()->all());

        return view('admin.account.list', compact('admins'));
    }

    // Change Admin Role
    public function changeRole(Request $request) {
        User::find($request->adminId)->update([
            'role' => $request->role
        ]);
        return response()->json(200);
    }

    // Delete Admin
    public function delete($id) {
        $dbImage = User::find($id)->image;
        if($dbImage != null) {
            Storage::delete('public/profile/' . $dbImage);
        }

        User::find($id)->delete();
        return back()->with(['message' => 'Deleted successfully.']);
    }

    // Direct User List
    public function userList() {
        $users = User::when(request('searchKey'), function($query) {
            $query->orWhere('name', 'like', '%' . request('searchKey') . '%')
                ->orWhere('email', 'like', '%' . request('searchKey') . '%')
                ->orWhere('address', 'like', '%' . request('searchKey') . '%')
                ->orWhere('phone', 'like', '%' . request('searchKey') . '%');
        })
            ->where('role', 'user')
            ->paginate(3);

        return view('admin.user.list', compact('users'));
    }

    // Change User Role
    public function changeUserRole(Request $request) {
        User::find($request->userId)->update([
            'role' => $request->role
        ]);
        return response()->json(200);
    }

    // Delete User
    public function deleteUser(Request $request) {
        $dbImage = User::find($request->userId)->image;
        if($dbImage != null) {
            Storage::delete('public/profile/' . $dbImage);
        }

        User::find($request->userId)->delete();
        return response()->json(200);
    }

    // -------------- Check Profile Validation --------------------
    private function checkProfileValidation($request) {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'image' => 'mimes:jpg,png,jpeg,webp'
        ])->validate();
    }

    // Check Password Validation
    private function checkPasswordValidation($request) {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8|same:newPassword',
        ])->validate();
    }
}
