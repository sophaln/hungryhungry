<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BasicAuth
{
    /**
     * Handle an incoming request.
     * Basic authentication
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Just a dummy username and password, for coding challenge purpose
        $user = 'sophal';
        $pass = 'hungryhungry'; // should be hashed
        $is_authenticated = false;
        
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        $is_authenticated = ($has_supplied_credentials && $_SERVER['PHP_AUTH_USER'] === $user && $_SERVER['PHP_AUTH_PW'] === $pass);
        if (!$is_authenticated) {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            throw new HttpException(401, 'Invalid Username or Password');
        }
        return $next($request);
    }
}
