<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'phone',
        'email'
    ];

    public function addresses()
    {
        return $this->hasMany(ClientAddress::class, 'client_id', 'id');
    }
}
