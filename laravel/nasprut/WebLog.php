<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;

class WebLog
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
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            $_SERVER['HTTP_USER_AGENT'] = 'unknown';
        }
        $ExactBrowserNameUA=$_SERVER['HTTP_USER_AGENT'];

        if (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")) {
            // OPERA
            $ExactBrowserNameBR="opera";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "chrome/")) {
            // CHROME
            $ExactBrowserNameBR="chrome";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "msie")) {
            // INTERNET EXPLORER
            $ExactBrowserNameBR="ie";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "firefox/")) {
            // FIREFOX
            $ExactBrowserNameBR="firefox";
        } elseIf (strpos(strtolower($ExactBrowserNameUA), "safari/") and strpos(strtolower($ExactBrowserNameUA), "opr/")==false and strpos(strtolower($ExactBrowserNameUA), "chrome/")==false) {
            // SAFARI
            $ExactBrowserNameBR="safari";
        } else {
            // OUT OF DATA
            $ExactBrowserNameBR="unknown";
        };


        Storage::append('logs/web.log', $request->path() . ' ' . $ExactBrowserNameBR);
        return $next($request);
    }


}
