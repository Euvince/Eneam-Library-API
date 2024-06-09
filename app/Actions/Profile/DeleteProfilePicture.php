<?php

namespace App\Actions\Profile;

use App\Contracts\DeleteUserPicture;

class DeleteProfilePicture implements DeleteUserPicture
{
    public function delete($user) {
        $user->deleteProfilePicture();
    }
}
