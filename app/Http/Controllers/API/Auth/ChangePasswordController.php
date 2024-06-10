<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request) {

        $password = Hash::make($request->validated('password'));
        $user = User::where('id', Auth::user()->id);

        $user->update([
            'password' => $password,
            'haschangedpwd' => true,
        ]);
        return redirect()->intended(route('document.index'));
    }
}
