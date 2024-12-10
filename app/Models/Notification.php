<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = ['type', 'data', 'notifiable_id', 'notifiable_type'];
    protected $keyType = 'string';


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'notifiable_id', 'id');
    }
}
