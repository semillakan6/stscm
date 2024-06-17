<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;
    protected $collection = 'permissions'; // Set your desired collection name here
}
