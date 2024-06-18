<?php

namespace App\Http\Controllers\API\Auth;

use App\Actions\Profile\DeleteProfilePicture;
use App\Actions\Profile\UpdateProfilePicture;
use App\Http\Controllers\Controller;
use App\Http\Responses\Auth\DeletePictureResponse;
use App\Http\Responses\Auth\UpdatePictureResponse;
use Illuminate\Http\Request;

class ProfilePictureController extends Controller
{
    /**
     * Update authenticated user profile photo.
     */
    public function update(Request $request, UpdateProfilePicture $updater) : UpdatePictureResponse
    {
        $updater->update($request->user(), $request->all());
        return app(UpdatePictureResponse::class);
    }

    /**
     * Delete authenticated user profile photo.
     */
    public function delete(Request $request, DeleteProfilePicture $deleter) : DeletePictureResponse
    {
        $deleter->delete($request->user());
        return app(DeletePictureResponse::class);
    }

}
