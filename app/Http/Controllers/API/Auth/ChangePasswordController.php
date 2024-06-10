<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\ChangePasswordRequest;

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
