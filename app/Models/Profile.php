<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'birthday',
        'gender',
        'interested_in',
        'location',
        'age_from',
        'age_to'
    ];


}
