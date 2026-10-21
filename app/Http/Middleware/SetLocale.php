<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request and set current application locale.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale') ?? $request->cookie('locale') ?? config('app.locale', 'en');

        if (!in_array($locale, ['en', 'km', 'kh'])) {
            $locale = 'en';
        }

        $standardLocale = ($locale === 'kh') ? 'km' : $locale;
        App::setLocale($standardLocale);
        view()->share('currentLocale', $standardLocale);

        return $next($request);
    }
}
