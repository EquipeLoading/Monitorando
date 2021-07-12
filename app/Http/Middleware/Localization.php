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
    public function handle($request, Closure $next) {
        if (session()->has('locale')) {
            app()->setlocale(session()->get('locale'));
        }
        return $next($request);
    }
}