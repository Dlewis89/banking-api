<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_admin'
    ];

    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
