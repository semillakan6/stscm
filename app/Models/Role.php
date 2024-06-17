<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use MongoDB\Laravel\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $collection = 'roles'; // Set your desired collection name here
    protected $fillable = ['access_', 'grant_', 'status', 'icon', 'name', 'role', 'status', 'permissions'];
}
