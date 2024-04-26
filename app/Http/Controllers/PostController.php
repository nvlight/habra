<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): Post
    {
        $attributes = $request->validated();

        /** @var Post $post */
        $post = Post::query()->create($attributes);

        return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Post
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post):void
    {
        Gate::allowIf(fn(User $user) => $post->isOwnedBy($user));

        $attributes = $request->validated();

        $post->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): void
    {
        Gate::allowIf(fn(User $user) => $post->isOwnedBy($user));

        $post->delete();
    }
}
