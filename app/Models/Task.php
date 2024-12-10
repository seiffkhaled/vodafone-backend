<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_date',
        'completion_date',
        'due_date',
        'status'
    ];

    public static function getTaskStatus()
    {
        return ['Pending', 'Completed', 'Overdue'];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
