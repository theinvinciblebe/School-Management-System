<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            Log::info('Middleware executed for user ID: ' . Auth::id());

            $ipAddress = $request->ip();
            $timestamp = now();

            // Optionally use a geolocation API to fetch location
            $geoLocation = $this->getGeoLocation($ipAddress);

            Log::info('User Activity', [
                'user_id' => Auth::id(),
                'ip_address' => $ipAddress,
                'geo_location' => $geoLocation,
                'timestamp' => $timestamp,
            ]);

            // Alternatively, store the data in the database
            \App\Models\ActivityLog::create([
                'user_id' => Auth::id(),
                'ip_address' => $ipAddress,
                'geo_location' => $geoLocation,
                'timestamp' => $timestamp,
            ]);
        } else {
            Log::info('User not authenticated. Skipping activity log.');
        }

        return $next($request);
    }
    private function getGeoLocation($ip)
    {
        try {
            $geoData = file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($geoData, true);


            if ($data && $data['status'] === 'success') {
                return "{$data['city']}, {$data['regionName']}, {$data['country']}";
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch geolocation', ['ip' => $ip, 'error' => $e->getMessage()]);
        }

        return 'Unknown';
    }


}
