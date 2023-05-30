<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $table ='bill';
    protected $fillable=
    [
        'idUser',
        'id_cart',
        'email',
        'name',
        'price',
        'numberPhone',
        'address',
        'genaral',
        'created_at',
        'updated_at'
    ];
}
