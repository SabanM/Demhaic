<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class TrustProxies
{

protected $proxies = '*'; // or specific IPs

protected $headers = Request::HEADER_X_FORWARDED_ALL;
}