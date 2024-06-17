<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Modules extends Model
{
    use HasFactory;
    protected $collection = 'modules'; // Set your desired collection name here
}
