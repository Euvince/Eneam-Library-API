<?php

namespace App\Contracts;

interface DeleteUserPicture
{

    /**
     * Update an attribute on User model.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function delete($user);
}
