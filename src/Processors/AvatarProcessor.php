<?php


namespace App\Processors;


use Illuminate\Support\Str;

class AvatarProcessor
{
    public static function get($model)
    {
        $file = $model->file()->first();

        if (is_null($file)) {
            if (isset($model->gender)) {
                //return 'https://avatars.dicebear.com/v2/initials/' .Str::slug($model->id) . '.svg';
                return sprintf(config('image.no_avatar'),$model->gender);
            }
            return config('image.no_image');
        }

        return $file->name;
    }
}
