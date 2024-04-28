<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Throwable;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Auth;


class AssignGuard extends BaseMiddleware

{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next , $guard = null )
    {
        $user = null;

        $type=auth($guard)->user();

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['success'=>false , 'msg'=>'Invalid_Token' ]);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['success'=>false , 'msg'=>'Expired_Token']);
            }else{
                return response()->json(['success'=>false , 'msg'=>'Token_Not_Found']);
            }
        }
        catch(Throwable $e){
             if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['success'=>false , 'msg'=>'Invalid_Token' ]);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['success'=>false , 'msg'=>'Expired_Token']);
            }else{
                return response()->json(['success'=>false , 'msg'=>'Token_Not_Found']);
            }
        }

       if($type){
        return $next($request);
       }
       return response()->json(['message'=>"Invalid User"]);
    }
}
