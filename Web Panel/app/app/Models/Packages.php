<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'amount',
        'day',
        'multi',
        'server',
        'traffic',
        'multiuser'
    ];
    public function users() {
        return $this->hasMany(Users::class, 'server', 'id');
    }

    public function servers() {
        return $this->hasMany(Servers::class, 'id', 'server');
    }
}
