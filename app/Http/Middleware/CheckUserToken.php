<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\User as UserModel;
use App\Exceptions\UserTokenExpired as UserTokenExpired;
class CheckUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('authorization');
        try{
            UserModel::where('token', '=', $token)->whereNotNull('token')->firstOrFail();
        }catch(\Exception $exception){
            throw new UserTokenExpired('登录已过期');
        }
        return $next($request);
    }
}
