<?php

namespace App\Contracts;

interface UpdateUserPicture
{

    /**
     * Update an attribute on User model.
     *
     * @param  array<string, string> $input
     * @param  \App\Models\User $user
     * @return void
     */
    public function update($user, $input);
}
