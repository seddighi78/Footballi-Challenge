<?php

namespace App\Exceptions;

use App\Http\Resources\DefaultResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {
        if (!$request->wantsJson()) {
            return parent::render($request, $exception);
        }

        if ($exception instanceof ThrottleRequestsException) {
            DefaultResource::$code = Response::HTTP_TOO_MANY_REQUESTS;
            DefaultResource::$message = __('messages.exception.too_many_request');

            return (new DefaultResource([]))->response();
        }

        if ($exception instanceof ModelNotFoundException) {
            DefaultResource::$code = Response::HTTP_NOT_FOUND;
            DefaultResource::$message = __('messages.exception.not_found');

            return (new DefaultResource([]))->toResponse($request);
        }

        if ($exception instanceof NotFoundHttpException) {
            DefaultResource::$code = Response::HTTP_NOT_FOUND;
            DefaultResource::$message = __('messages.exception.not_found');

            return new DefaultResource([]);
        }

        if ($exception instanceof UnauthorizedException) {
            DefaultResource::$code = Response::HTTP_UNAUTHORIZED;
            DefaultResource::$message = __('auth.failed');

            return new DefaultResource([]);
        }

        if ($exception instanceof AuthorizationException) {
            DefaultResource::$code = Response::HTTP_FORBIDDEN;
            DefaultResource::$message = __('auth.failed');

            return new DefaultResource([]);
        }

        if ($exception instanceof ValidationException) {
            $errors = $exception->validator->getMessageBag()->getMessages();

            DefaultResource::$code = Response::HTTP_UNPROCESSABLE_ENTITY;
            DefaultResource::$message = __('validation.message');

            return new DefaultResource(['validation_errors' => $errors]);
        }

        if ($exception instanceof AuthenticationException) {
            DefaultResource::$code = Response::HTTP_FORBIDDEN;
            DefaultResource::$message = __('auth.failed');

            return new DefaultResource([]);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            DefaultResource::$code = Response::HTTP_FORBIDDEN;
            DefaultResource::$message = __('auth.access_denied');

            return new DefaultResource([]);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            DefaultResource::$code = Response::HTTP_METHOD_NOT_ALLOWED;
            DefaultResource::$message = __('messages.exception.method_not_allow');

            return new DefaultResource([]);
        }

        if ($exception instanceof BadRequestException || $exception->getCode() === 400) {
            DefaultResource::$code = Response::HTTP_BAD_REQUEST;
            DefaultResource::$message = empty($exception->getMessage()) ? __('messages.exception.bad_request') : $exception->getMessage();

            return new DefaultResource([]);
        }

        DefaultResource::$code = 500;
        DefaultResource::$message = $exception->getMessage();

        return (new DefaultResource([]))->toResponse($request);
    }
}
