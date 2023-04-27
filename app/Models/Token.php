<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $table = 'token_permission';

    protected $fillable = [
        'id',
        'token_update',
        'token_delete',
        'user_id',
        'method'
	];
}
