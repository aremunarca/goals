<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenCheckMiddleware
{
    
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        $response = null;
        $user_intranet = null;
       
        if(auth('sanctum')->check()){
            $user_intranet = UserIntranet::where('id',auth('sanctum')->user()->user_intranet_id)->first();
            $response = $this->curlIntranet($user_intranet);
        }else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$this->isValidAuth($response, $user_intranet)) {
           return response()->json(['data' => 'Authorization is not valid'], 401);
        }

        return $next($request);
    }

    private function isValidAuth($response,$user)
    {   
        if(array_key_exists('user', $response)){
            if($response['user']->id == $user->id) {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}
