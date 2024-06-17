<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use HTMLPurifier;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $purifier;

    public function __construct()
    {
        $this->purifier = app(HTMLPurifier::class);
    }

}
