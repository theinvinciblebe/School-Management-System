<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'method',
        'url',
        'ip_address',
        'geo_location',
        'user_agent',
        'device',
        'status_code',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault([
            'name' => 'Unknown / Deleted User',
            'email' => 'n/a',
            'role' => null,
            'photo' => 'noimg.jpg',
        ]);
    }

    /**
     * Parse device from user agent
     */
    public static function parseDevice(?string $userAgent): string
    {
        if (empty($userAgent)) {
            return 'Unknown Device';
        }

        $ua = strtolower($userAgent);

        if (str_contains($ua, 'ipad') || str_contains($ua, 'tablet')) {
            return 'Tablet';
        }

        if (str_contains($ua, 'mobile') || str_contains($ua, 'iphone') || str_contains($ua, 'android')) {
            return 'Mobile Phone';
        }

        if (str_contains($ua, 'windows')) {
            return 'Desktop (Windows)';
        }

        if (str_contains($ua, 'macintosh') || str_contains($ua, 'mac os')) {
            return 'Desktop (macOS)';
        }

        if (str_contains($ua, 'linux')) {
            return 'Desktop (Linux)';
        }

        if (str_contains($ua, 'curl') || str_contains($ua, 'postman') || str_contains($ua, 'python')) {
            return 'API Client / Bot';
        }

        return 'Desktop Browser';
    }

    /**
     * Fast local / internal IP detection & cached geo lookup
     */
    public static function resolveGeoLocation(string $ip): string
    {
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost']) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.') || str_starts_with($ip, '172.16.')) {
            return 'Localhost / Internal';
        }

        // Return from cache or fallback quickly without blocking
        try {
            return cache()->remember("ip_geo_{$ip}", 86400, function () use ($ip) {
                $ctx = stream_context_create([
                    'http' => [
                        'timeout' => 1.0, // 1 second strict timeout
                    ]
                ]);
                $geoData = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city", false, $ctx);
                if ($geoData) {
                    $data = json_decode($geoData, true);
                    if (!empty($data) && ($data['status'] ?? '') === 'success') {
                        $parts = array_filter([$data['city'] ?? '', $data['regionName'] ?? '', $data['country'] ?? '']);
                        return implode(', ', $parts) ?: 'Unknown';
                    }
                }
                return 'External Network';
            });
        } catch (\Throwable $e) {
            return 'External Network';
        }
    }

    /**
     * Record a custom activity log event programmatically
     */
    public static function record(string $action, ?string $description = null, $request = null, $user = null): ?self
    {
        try {
            $user = $user ?? Auth::user();
            if (!$user) {
                return null;
            }

            $req = $request ?: request();
            $ip = $req ? $req->ip() : '127.0.0.1';
            $userAgent = $req ? $req->userAgent() : null;

            return self::create([
                'user_id' => $user->id,
                'action' => $action,
                'description' => $description,
                'method' => $req ? strtoupper($req->method()) : 'SYSTEM',
                'url' => $req ? $req->path() : null,
                'ip_address' => $ip,
                'geo_location' => self::resolveGeoLocation($ip),
                'user_agent' => $userAgent ? substr($userAgent, 0, 500) : null,
                'device' => self::parseDevice($userAgent),
                'status_code' => 200,
                'timestamp' => now(),
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Failed recording activity log: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Return user role label
     */
    public function getRoleNameAttribute(): string
    {
        $role = $this->user->role;
        return match ($role) {
            0, '0' => 'Admin',
            1, '1' => 'Teacher',
            2, '2' => 'Student',
            3, '3' => 'Accountant',
            4, '4' => 'Receptionist',
            default => 'Unknown Role'
        };
    }

    /**
     * Role badge styling
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return match ($this->user->role) {
            0, '0' => 'badge-danger',
            1, '1' => 'badge-primary',
            2, '2' => 'badge-success',
            3, '3' => 'badge-warning text-dark',
            4, '4' => 'badge-info',
            default => 'badge-secondary'
        };
    }

    /**
     * Method badge styling
     */
    public function getMethodBadgeClassAttribute(): string
    {
        return match (strtoupper($this->method ?? 'GET')) {
            'POST' => 'badge-success',
            'PUT', 'PATCH' => 'badge-warning text-dark',
            'DELETE' => 'badge-danger',
            'GET' => 'badge-info',
            default => 'badge-secondary'
        };
    }

    /**
     * Icon for device
     */
    public function getDeviceIconAttribute(): string
    {
        $device = strtolower($this->device ?? '');
        if (str_contains($device, 'mobile') || str_contains($device, 'phone')) {
            return 'fas fa-mobile-alt text-primary';
        }
        if (str_contains($device, 'tablet') || str_contains($device, 'ipad')) {
            return 'fas fa-tablet-alt text-info';
        }
        if (str_contains($device, 'bot') || str_contains($device, 'api')) {
            return 'fas fa-robot text-danger';
        }
        return 'fas fa-desktop text-secondary';
    }

    /**
     * Icon & color for action
     */
    public function getActionIconAttribute(): string
    {
        $action = strtolower($this->action ?? '');
        $method = strtoupper($this->method ?? '');

        if (str_contains($action, 'login') || str_contains($action, 'sign in')) {
            return 'fas fa-sign-in-alt text-success';
        }
        if (str_contains($action, 'logout') || str_contains($action, 'sign out')) {
            return 'fas fa-sign-out-alt text-danger';
        }
        if (str_contains($action, 'delete') || $method === 'DELETE') {
            return 'fas fa-trash-alt text-danger';
        }
        if (str_contains($action, 'create') || str_contains($action, 'add') || str_contains($action, 'store') || $method === 'POST') {
            return 'fas fa-plus-circle text-success';
        }
        if (str_contains($action, 'update') || str_contains($action, 'edit') || in_array($method, ['PUT', 'PATCH'])) {
            return 'fas fa-edit text-warning';
        }
        if (str_contains($action, 'export') || str_contains($action, 'download') || str_contains($action, 'print')) {
            return 'fas fa-file-export text-info';
        }
        if (str_contains($action, 'clear') || str_contains($action, 'purge')) {
            return 'fas fa-broom text-danger';
        }
        return 'fas fa-eye text-primary';
    }
}
