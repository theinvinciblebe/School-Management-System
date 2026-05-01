<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingModel extends Model
{
    use HasFactory;
}
class FeeReceipt extends Model
{
    protected $fillable = [
        'receipt_no',
        'student_class_id',
        'paid',
        'paid_via',
        'date',
        'previous_balance',
        'status', // Add this
    ];
}
