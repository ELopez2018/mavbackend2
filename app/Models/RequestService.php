<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestService extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(App\Models\User::class);
    }
    public function requestType()
    {
        return $this->belongsTo(App\Models\requestType::class);
    }
    public function serviceType()
    {
        return $this->belongsTo(App\Models\ServicesType::class);
    }
    public function requestState()
    {
        return $this->belongsTo(App\Models\RequestState::class);
    }
}
