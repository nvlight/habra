<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Comment::truncate();
        // sail artisan db:seed --class=CommentSeeder

        // вариант сидера 1. Делает только одноуровневые комментарии
//        Post::query()->get()
//            ->flatMap(fn(Post $post) => static::seedCommentsFor($post))
//            ->each(fn(Comment $comment) => static::associateParentCommentWith($comment));

        // вариант сидера 2.1 Сделаем теперь через методы моделей пост и коммент.
//        Post::query()->take(1)->get()
//            ->flatMap(fn(Post $post) => $post->createRandomComment())
//            ->each(fn(Comment $comment) => $comment->assosiacteparentComment());

        // вариант сидера 2.2 Тоже самое что и в 2.1, но используем фичу сообщения высшего порядка
        Post::query()->take(1)->get()
            ->flatMap
            ->createRandomComments()
            ->each
            ->associateParentComment();

    }

    // следующие 3 функции используются только в варианте с --- вариант сидера 1
    private static function seedCommentsFor(Post $post)
    {
        $comments = Comment::factory(fake()->numberBetween(11, 21))->create();

        $post->comments()->saveMany($comments);

        //return $comments->pluck('id')->all();
        return $comments;
    }

    private static function associateParentCommentWith(Comment $comment)
    {
        if ($comment->replies->isNotEmpty()) return;

        $comment->parent()->associate(static::findRandomCommentThatCanBeParentOff($comment))->save();
    }

    private static function findRandomCommentThatCanBeParentOff(Comment $comment)
    {
        return $comment->post
            ->comments()
            ->doesntHave('parent')
            ->where('id', '<>', $comment->id)
            ->inRandomOrder()
            ->first();
    }
}
