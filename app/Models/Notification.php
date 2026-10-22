<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'type',
        'target_id',
        'target_type',
        'action_url',
        'status',
        'message',
        'is_read',
        'starred',
        'data',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'starred' => 'boolean',
        'data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getIconAttribute(): string
    {
        $type = strtolower((string)$this->type);
        if (str_contains($type, 'purchase')) {
            return 'fas fa-shopping-cart';
        }
        if (str_contains($type, 'fee')) {
            return 'fas fa-receipt';
        }
        if (str_contains($type, 'admission')) {
            return 'fas fa-user-graduate';
        }
        if (str_contains($type, 'attendance')) {
            return 'fas fa-calendar-check';
        }
        return 'fas fa-bell';
    }

    public function getStatusColorAttribute(): string
    {
        $status = strtolower((string)$this->status);
        return match ($status) {
            'approved' => 'success',
            'rejected' => 'danger',
            'pending' => 'warning',
            default => 'info',
        };
    }

    public static function notifyAdmins(array $data)
    {
        $admins = User::where('role', 0)->get();
        $senderId = auth()->id() ?? $data['user_id'] ?? null;
        $created = [];

        foreach ($admins as $admin) {
            $created[] = self::create(array_merge($data, [
                'user_id' => $senderId,
                'admin_id' => $admin->id,
                'is_read' => false,
            ]));
        }

        return $created;
    }

    public static function notifyUser($userId, array $data)
    {
        if (!$userId) {
            return null;
        }

        $adminId = auth()->id() ?? 1;

        return self::create(array_merge($data, [
            'user_id' => $userId,
            'admin_id' => $adminId,
            'is_read' => false,
        ]));
    }

    public static function updateTargetStatus(string $targetType, $targetId, string $status)
    {
        return self::where('target_type', $targetType)
            ->where('target_id', $targetId)
            ->update(['status' => $status]);
    }
}
