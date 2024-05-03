<?php

use Illuminate\Http\JsonResponse;

function responseOk(): JsonResponse
{
    return response()->json([
        'status' => 1,
        'message' => 'product deleted',
    ]);
}
function responseFailed(?string $message = null, int $code = 400 ): JsonResponse
{
    return response()->json([
        'status' => 0,
        'message' => $message,
    ], $code);
}

function getMessage(string $code = ''): ?string
{
    return __("messages.$code");
}
