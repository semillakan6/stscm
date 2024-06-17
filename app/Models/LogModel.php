<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class LogModel extends Model
{
    use HasFactory;
    protected $collection = 'logs';
    protected $fillable = [
        'tag_log', 'made_log', 'alter_log', 'info_log', 'alert_log','status', 'madeToId','alterId'
    ];
}
