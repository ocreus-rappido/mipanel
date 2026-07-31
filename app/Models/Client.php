<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'mobile_phone',
        'address',
        'id_card',
        'zone',
        'observations',
        'tv_services',
        'cameras',
        'mobile_equipment',
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}