<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'photo'
    ];

    public $timestamps = false;

    public static function boot() {

        parent::boot();

        static::created(function($photo) {
            DB::table('dislikes')
                ->where('liked_user_id', $photo->user_id)
                ->delete();
        });
    }
}
