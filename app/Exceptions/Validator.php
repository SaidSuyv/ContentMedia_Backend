<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Throwable;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

use Exception;

class Validator extends Exception
{
  public function render(Request $request, Throwable $exception)
  {
    if( $exception instanceof ValidationException )
    {
      return response()->json(["errors"=>$exception->errors()],Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    return response()->json(["message"=>$exception->getMessage()],Response::HTTP_UNPROCESSABLE_ENTITY);
  }
}
