<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Config;
use App\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function findConfig($name)
    {
        $config = Config::where('name', $name)->first();
        return $config->value;
    }

    public function addlog($message)
    {
        $log = new Log;
        $log->user_id = Auth::user()->id;
        $log->message = $message;
        $log->save();
    }
}
