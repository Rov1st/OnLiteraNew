<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cari user berdasar email
        $user = User::where('email', $credentials['email'])->first();

        // Cek user dan password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Email atau password salah.'],
            ]);
        }

        // Buat token API
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kembalikan response JSON
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'display_name' => ['required', 'string', 'max:225'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'display_name' => $validated['display_name'],
        ]);

        // Buat token langsung jika mau auto-login
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
     public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Cek apakah password lama sesuai
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Password lama salah'], 400);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password berhasil diperbarui']);
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'no_telp' => 'required|numeric|min:10',
        ]);
        /** @var User $user */
        $user = Auth::user();
        $user->no_telp = $request->no_telp;
        $user->save(); // <— di sini `save()` harusnya jalan, asal $user itu instance model User

        return response()->json(['message' => 'Phone number updated successfully', 'user' => $user]);
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->update($request->only([
        'display_name', 'NIK', 'NISN', 'kelas'
    ]));

    return response()->json([
        'message' => 'Data user berhasil diperbarui',
        'user' => $user
    ]);
}

}
