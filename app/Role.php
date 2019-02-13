<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'descr'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
