<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

/**
 * Class Localization
 * @author May Thin Khaing
 * @created 05/07/2023
 */
class Localization
{
    /**
     * Handle an incoming request.
     * @author May Thin Khaing
     * @created 05/07/2023
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get the selected language from the session or use the default
        $locale = $request->session()->get('locale', config('app.locale'));

        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}
