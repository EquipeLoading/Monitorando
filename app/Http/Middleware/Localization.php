<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     //Validação e integração do parâmetro Locale passado pela rota como o setLocale da aplicação
    public function handle($request, Closure $next)
    {
        $availableLangs = ['pt-BR', 'en' ];
        $userLangs = preg_split('/,|;/', $request->server('HTTP_ACCEPT_LANGUAGE'));
        foreach ($availableLangs as $lang) {
            if($lang == $userLangs[0]) {
                app()->setLocale($lang);
                break;
            }
        }

        return $next($request);
    }
}