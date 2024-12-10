<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportSubscription extends Model
{
    use SoftDeletes;
    protected $table = "report_subscriptions";
    protected $fillable = [
        'user_id',
        'start_date',
        'frequency',
        'report_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
