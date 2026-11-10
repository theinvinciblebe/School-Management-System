<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $table = 'calendar_events';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'start_date',
        'end_date',
        'all_day',
        'bg_color',
        'border_color',
        'text_color',
        'url',
    ];

    protected $casts = [
        'all_day'    => 'boolean',
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

