<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\YaumiActivity;
use App\Models\YaumiLog;
use App\Models\YaumiStreak;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1️⃣ Users
        $users = User::factory(4)->create(); // 4 user random
        $adminUser = User::factory()->create([
            'name' => 'Themas',
            'email' => 'themas@email.com',
            'password' => bcrypt('12345678'), // jangan lupa bcrypt
        ]);

        $users = $users->concat([$adminUser]);


        // 2️⃣ Categories & Tags
        $categories = Category::factory(5)->create();
        $tags = Tag::factory(10)->create();

        // 3️⃣ Posts
        $posts = Post::factory(20)->make()->each(function ($post) use ($users, $categories, $tags) {
            $post->user_id = $users->random()->id;
            $post->category_id = $categories->random()->id;
            $post->save();

            // attach random tags
            $post->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        });

        // 4️⃣ Comments
        $posts->each(function ($post) use ($users) {
            Comment::factory(rand(2, 5))->create([
                'post_id' => $post->id,
                'user_id' => $users->random()->id,
            ]);
        });

        // 5️⃣ Yaumi Activities
        $activities = YaumiActivity::factory(10)->create();

        // 6️⃣ Yaumi Logs
        $users->each(function ($user) use ($activities) {
            YaumiLog::factory(rand(3, 7))->create([
                'user_id' => $user->id,
                'activity_id' => $activities->random()->id,
            ]);
        });

        // 7️⃣ Yaumi Streaks
        $users->each(function ($user) {
            YaumiStreak::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
