<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class BaseController extends Controller
{
    protected $response = [];
    protected $status = false;
    protected $message;

    public function __construct()
    {
    }
}
