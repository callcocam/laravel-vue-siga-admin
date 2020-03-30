<?php

use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\User::query()->get()->each(function ($user){
            $this->blog($user);
        });
    }


    private function blog(\App\User $user){

        if($user->hasRole('funcionario')){
            $user->category()->create(factory(App\Category::class)->make([
                'user_id'=>$user->id,
            ])->toArray())->each(function ($category) use ($user){
                $user->tag()->create(factory(App\Tag::class)->make([
                    'user_id'=>$user->id,
                ])->toArray())->each(function ($tag) use ($user,$category){
                    $user->posts()->create(factory(App\Post::class)->make([
                        'user_id'=>$user->id,
                        'category_id'=>$category->id,
                    ])->toArray())->each(function ($post) use ($user,$tag) {
                        $post->file()->create(factory(\App\File::class)->make()->toArray());
                        $post->tags()->attach($tag->id);
                        $post->comments()->save(factory(App\Comment::class)->make([
                            'user_id'=>$user->id,
                        ]));
                    });
                });
            });
        }
    }

    public function array($max)
    {
        $values = [];

        for ($i=1; $i < $max; $i++) {
            $values[] = $i;
        }

        return $values;
    }
}
