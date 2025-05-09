<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'clients';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'address',
    ];

    // If you don't need timestamps, you can disable them like this:
    public $timestamps = true; // Or set to false if you don't want timestamps
}
