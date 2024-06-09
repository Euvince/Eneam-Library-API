<?php

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasProfilePicture
{
    /**
     * Update the user's profile picture
     *
     * @param \Illuminate\Http\UploadedFile $picture
     * @return void
     */
    public function updateProfilePicture (UploadedFile $picture) : void {
        tap(value : $this->profile_picture_path, callback : function ($previous) use($picture) {
            $this->forceFill([
                'profile_picture_path' => $picture->storePublicly(
                    'User/profiles-pictures', ['disk' => $this->profilePictureDisk()]
                )
            ])->save();
            if ($previous) Storage::disk($this->profilePictureDisk())->delete($previous);
        });
    }

    /**
     * Delete the user's profile picture
     *
     * @return void
     */
    public function deleteProfilePicture () : void {
        if (is_null($this->profile_picture_path)) return;
        Storage::disk($this->profilePictureDisk())->delete($this->profile_picture_path);
        $this->forceFill([
            'profile_picture_path' => NULL
        ])->save();
    }

    /**
     * Get the URL to the user's profile picture
     *
     * @return void
     */
    public function getProfilePictureUrlAttribute () {
        return $this->profile_picture_path
            ? Storage::disk($this->profilePictureDisk())->url($this->profile_picture_path)
            : $this->defaultProfilePictureUrl();
    }

    /**
     * Get the default profile picture URL if no profile picture has been updated
     *
     * @return string
     */
    protected function defaultProfilePictureUrl () {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' ', ));
        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that profile photoss should be stored on.
     *
     * @return string
     */
    protected function profilePictureDisk() : string {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config(key : 'fortify.profile_picture_path', default : 'public');
    }

}
