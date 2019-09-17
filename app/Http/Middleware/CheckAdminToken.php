<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Admin as AdminModel;
use App\Exceptions\AdminTokenExpired as AdminTokenExpired;
class CheckAdminToken
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
            AdminModel::where('token', '=', $token)->whereNotNull('token')->firstOrFail();
        }catch(\Exception $exception){
            throw new AdminTokenExpired('登录已过期');
        }
        return $next($request);
    }
}
