<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relación con los contratos
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}