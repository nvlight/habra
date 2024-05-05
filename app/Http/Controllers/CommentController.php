<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\Resources\CommentResource;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): array
    {
        return CommentResource::collection(Comment::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request): Comment
    {
        $attributes = $request->validated();

        // эти две операции были унесены в booted --> saving этой модели.
        //$attributes['user_id'] = $request->user()->id;
        // если parent_id есть, мы берем его post_id
//            if (isset($attributes['parent_id'])){
//                $attributes['post_id'] = Comment::query()->find($attributes['parent_id'])->post_id;
//            }

        /** @var Comment $comment */
        $comment = Comment::query()->create($attributes);

        return $comment;
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): array
    {
        return (new CommentResource($comment))->resolve();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment): void
    {
        // if PUT -- 204 No Content
        // if PATCH --

        Gate::allowIf(fn(User $user) => $comment->isOwnedBy($user));

        $attributes = $request->validated();

        $comment->update($attributes);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): void
    {
        Gate::allowIf(fn(User $user) => $comment->isOwnedBy($user));

        $comment->delete();
    }

}
