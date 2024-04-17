<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Comment::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $attributes = $request->validated();

        $attributes['user_id'] = $request->user()->id;

        // если parent_id есть, мы берем его post_id
        if (isset($attributes['parent_id'])){
            $attributes['post_id'] = Comment::query()->find($attributes['parent_id'])->post_id;
        }

        /** @var Comment $comment */
        $comment = Comment::query()->create($attributes);

        $result = response()->json([
            'attributes' => $attributes,
            'success' => 1,
            'item' => $comment,
        ]);

        return $result;
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): Comment
    {
        return $comment;
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateCommentRequest $request, Comment $comment): JsonResponse
    {
        //auth()->loginUsingId(16);

        // variant 1
//        if ($request->user()->isNot($comment->user) ){
//            throw new AuthorizationException();
//        }
        // variant 2
//        abort_if($request->user()->isNot($comment->user),
//            Response::HTTP_UNAUTHORIZED, 'Unauthorized');

        if ($request->user()->isNot($comment->user)){
            return response()->json([
                'success' => 0,
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $attributes = $request->validated();

        //$comment->text = $attributes['text'];
        $comment->update($attributes);

        $result = response()->json([
            'attributes' => $attributes,
            'success' => 1,
            'item' => $comment,
        ]);

        return $result;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $delete_id = $comment->id;

        if (auth()->user()->id !== $comment->user_id){
            return response()->json([
                'success' => 0,
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $comment->delete();

        $result = response()->json([
            'delete_id' => $delete_id,
            'success' => 1,
        ]);

        return $result;
    }
}
