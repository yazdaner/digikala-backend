<?php

namespace Modules\sellers\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class SellerAuthenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards): Response
    {
        $this->authenticate($request, ['seller']);
        return $next($request);
    }

    protected function redirectTo(Request $request): ?string
    {
        abort(401,'Unauthorized');
    }
}
