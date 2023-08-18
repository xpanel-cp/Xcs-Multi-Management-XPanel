<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $fillable = [
        'server',
        'username',
        'password',
        'email',
        'mobile',
        'multiuser',
        'start_date',
        'end_date',
        'date_one_connect',
        'customer_user',
        'status',
        'traffic',
        'package',
        'desc'
    ];
    public function traffics() {
        return $this->hasMany(Traffic::class, 'username', 'username');
    }

    public function servers() {
        return $this->hasMany(Servers::class, 'id', 'server');
    }

    public function packages() {
        return $this->hasMany(Packages::class, 'id', 'package');
    }
}
