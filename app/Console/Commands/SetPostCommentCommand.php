<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class setPostCommentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:set-title {post_id} {title}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the new title for post by post_id';

    /**
     * Execute the console command.
     */
    public function handle():void
    {
        $postId = $this->argument('post_id');
        $post = Post::find($postId);

        /** Post $post */
        if ($post){
            $post->title = $this->argument('title');
            $post->save();
        }else{
            $this->info("Post doesn't exists. post_id: {$postId}");
        }

        $this->info("Title for post seted!");
    }
}
