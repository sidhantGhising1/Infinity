<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function show($id)
    {
        $admin = User::find($id);

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $admin
        ]);
    }

    // PUT: /api/admin/profile/{id}
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s]+$/', 'max:50'],
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => ['nullable','regex:/^(\+977\s?)?(98|97|96|01)\d{7,8}$/'],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($admin->image && file_exists(public_path('images/admin/' . $admin->image))) {
                unlink(public_path('images/admin/' . $admin->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/admin'), $imageName);
            $admin->image = $imageName;
        }

        $admin->name = $data['name'];
        $admin->email = $data['email'];
        $admin->phone = $data['phone'] ?? null;
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $admin
        ]);
    }

    // PUT: /api/admin/profile/{id}/change-password
    public function changePassword(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

        if (!Hash::check($request->current_password, $admin->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 401);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }
}
