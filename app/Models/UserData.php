<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;
    protected $table='users_data';
    protected $fillable=[
        'user_id',
        'first_name',
        'last_name',
        'dni',
        'avatar',
        'address',
        'mobile',
        'date_of_birth',
    ];

    protected $hident= ['deleted_at', 'created_at', 'update_ap'];
}
