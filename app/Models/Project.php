<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function approval()
    {
        return $this->hasMany(Approval::class)->orderByDesc('id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->title);
            $model->user_id = auth()->id();
        });
        static::updating(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }
}
