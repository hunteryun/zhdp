<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\User as UserModel;
use App\Http\Requests\User\CheckUserToken as CheckUserTokenRequests;
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
        (new CheckUserTokenRequests)->verification($request);
        $token = $request->input('token');
        try{
            UserModel::where('token', '=', $token)->firstOrFail();
        }catch(\Exception $exception){
            throw new UserTokenExpired('登录已过期');
        }
        return $next($request);
    }
}
