<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Company\CompanyNotFoundException;
use App\Models\Company;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Exceptions as BaseExceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use ReflectionProperty;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionHandler
{

    public function __invoke(Exceptions $exceptions): BaseExceptions
    {
        $this->renderUnauthorized($exceptions);
        $this->companyNotFound($exceptions);
        $this->renderNotFound($exceptions);

        return $exceptions;
    }

    protected function companyNotFound(BaseExceptions $exceptions):void
    {
        $exceptions->render(function (NotFoundHttpException $e) {

            if (! $previous = $e->getPrevious()){
                return;
            }

            $reflectionProperty = new ReflectionProperty($previous, 'model');
            $model = $reflectionProperty->getValue($previous);

            if ($model === Company::class) {
                throw new CompanyNotFoundException;
            }
        });
    }

    protected function renderUnauthorized(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(function (AuthenticationException $e, Request $request) {
            if (!$request->is('/api')) {
                return null;
            }

            return $this->response([
                'message' => __('Unauthorized'),
            ], 401);
        });
    }

    protected function renderNotFound(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {

                return $this->response([
                    'message' => __('API - Not Found'),
                ], 404);
            }

            return $this->response([
                'message' => __('Not Found'),
            ], 404);
        });
    }

    protected function response(mixed $data, int $status): JsonResponse
    {
        return response()->json($data, $status);
    }
}
