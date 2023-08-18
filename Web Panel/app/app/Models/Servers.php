<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    use HasFactory;
    protected $fillable = [
        'link',
        'token',
        'name',
        'port_connection',
        'port_connection_tls'
    ];

    public function packages()
    {
        return $this->belongsTo(Packages::class);
    }
}
