<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens( except: [
            'api/*'
        ] );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render( function( Throwable $exception, Request $request ){
            if( $exception instanceof ValidationException )
                return response()->json(["errors"=>$exception->errors()],Response::HTTP_UNPROCESSABLE_ENTITY);

            if( $exception instanceof ModelNotFoundException )
                return response()->json(["message"=>"No se ha encontrado el modelo solicitado"],Response::HTTP_NOT_FOUND);
            
            if( $exception instanceof NotFoundHttpException )
                return response()->json(["message"=>"No se ha encontrado el recurso solicitado"],Response::HTTP_NOT_FOUND);

            return response()->json(["message"=>$exception->getMessage(),"class"=>get_class($exception)],400);
        } );
    })->create();
