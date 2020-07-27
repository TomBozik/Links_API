<?php

namespace App\Services;
use Illuminate\Support\Facades\App;
use App\Tag;

class TagService
{
    public function getUserTags($user)
    {
        return Tag::where('user_id', $user->id)->get();
    }


    public function createTag($user, $tagName)
    {
        return Tag::firstOrCreate(
            ['user_id' => $user->id, 'name' => $tagName],
            ['user_id' => $user->id, 'name' => $tagName]
        );
    }

}