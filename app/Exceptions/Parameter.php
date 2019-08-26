<?php

namespace App\Exceptions;
// 参数验证错误
class Parameter extends Base
{
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
        return response()->json([
            'msg' => $this->message,
            'code' => 1,
        ], $this->code);
    }
}