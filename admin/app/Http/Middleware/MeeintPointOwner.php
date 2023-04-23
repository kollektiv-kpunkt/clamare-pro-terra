<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeeintPointOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->hasAnyRole(['admin', 'manager'])) {
            return $next($request);
        }
        $meetingPoint = $request->route('meeting_point');
        if (!$meetingPoint && ($request->route()->getName() == 'meeting_points.create' || $request->route()->getName() == 'meeting_points.store')) {
            return $next($request);
        }
        if (!$meetingPoint) {
            return redirect()->route('meeting_points.personal');
        }
        if ($meetingPoint->user_id !== auth()->user()->id) {
            return route('meeting_points.personal');
        }
        return $next($request);
    }
}
