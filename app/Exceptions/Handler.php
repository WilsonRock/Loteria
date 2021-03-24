<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e){

        });
    
        $this->renderable(function (Throwable $e) {
            return $this->handleException($e);
        });
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->errors()->getMessages();

        return $this->errorResponse($errors, 422);
    }

    public function handleException( Throwable $e){
        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
            $defaultMessage = \Symfony\Component\HttpFoundation\Response::$statusTexts[$code];
            $message = $e->getMessage() == "" ? $defaultMessage : $e->getMessage();
            return $this->errorResponse($message, $code);
        } else if ($e instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($e->getModel()));
            return $this->errorResponse("Does not exist any instance of {$model} with the given id", Response::HTTP_NOT_FOUND);
        } else if ($e instanceof AuthorizationException) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        } else if ($e instanceof AuthenticationException) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } else if ($e instanceof ValidationException) {
            $errors = $e->validator->errors()->getMessages();
            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else if ($e instanceof NotFoundHttpException) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_NOT_FOUND);
        } else if ($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_METHOD_NOT_ALLOWED);
        } else if ($e instanceof QueryException) {
            $code = $e->errorInfo[1];
            if ($code == 1451) {
                return $this->errorResponse('Cannot delete because it is related to another resource',Response::HTTP_CONFLICT);
            }
        } else if ($e instanceof HttpException) {
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        } else {
            if (config('app.debug')){
                    return $this->errorResponse($e->getMessage(), 500);
            }
            else {
                return $this->errorResponse('Try later', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
