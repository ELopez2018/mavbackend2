<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestServices extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'user_id',
    //     'request_type_id',
    //     'service_type_id',
    //     'telefono',
    //     'mensaje',
    // ];
    protected $guarded = [];
}
