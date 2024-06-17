<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;


class Dependencies extends Model
{
    use HasFactory;
    protected $collection = 'dependencies'; // Set your desired collection name here
    protected $fillable = ['name', 'active', 'status', 'tag', 'areas'];
}