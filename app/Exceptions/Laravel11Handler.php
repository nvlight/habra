<?php

namespace App\Exceptions;

use App\Exceptions\Company\CompanyNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Exceptions as BaseExceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Laravel11Handler
{
    public function __invoke(Exceptions $exceptions): BaseExceptions
    {
        //$this->renderUnauthorized($exceptions);
        $this->renderNotFound($exceptions);

        return $exceptions;
    }

    protected function renderNotFound(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if (!$request->is('/api')) {
                return null;
            }

            return $this->response([
                'message' => __('Not Found !!'),
            ], 404);
        });
    }

    protected function response(mixed $data, int $status): JsonResponse
    {
        return response()->json($data, $status);
    }

//    $exceptions->renderable(function (CompanyNotFoundException $e)
//    {
//        return responseFailed(getMessage('company not found'), 404);
//    });
//
//    $exceptions->render(function (NotFoundHttpException $e)
//    {
//        $previous = $e->getPrevious();
//        $reflectionProperty = new ReflectionProperty($previous, 'model');
//        $model = $reflectionProperty->getValue($previous);
//
//        if ($model === Company::class) {
//            throw new CompanyNotFoundException;
//        }
//
//        return responseFailed(getMessage('model_not_found'), 404);
//    });

    // mozhno i tak :smirk
//        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
//            if ($request->is('api/*')) {
//                return response()->json([
//                    'message' => 'Record not found.'
//                ], 404);
//            }
//        });
}
