<?php

namespace App\Actions\Profile;

use Illuminate\Http\UploadedFile;
use App\Contracts\UpdateUserPicture;
use Illuminate\Support\Facades\Validator;

class UpdateProfilePicture implements UpdateUserPicture
{
    public function update($user, $input) {
        Validator::make($input, [
            'profile_picture_path' => ['required', 'mimes:png,jpg, jpeg', 'max:2048']
        ])->validate();
        /**
         * @var UploadedFile $picture
         */
        $picture = $input['profile_picture_path'];
        if (isset($picture)) {
            $user->updateProfilePicture($picture);
        }
    }
}
