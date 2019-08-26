<?php

namespace App\Exceptions;

use Exception;

class Base extends Exception
{
    // http错误码
    public $httpCode = 200;
    // 状态 0 正常 1 错误
    public $statusCode = 0;
    //
    public $msg = '';
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        // code 最前面 msg在他后面
        return response()->json([
            'code' => $this->statusCode,
            'msg' => $this->message,
        ], $this->httpCode);
    }
}