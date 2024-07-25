<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * begin:: handler Response
     */
    protected function Response(?string $message, ?string $route, ?string $type = 'success')
    {
        if ($type == 'error') {
            Session::flash($type, $message);
            return Redirect::route($route);
        }
        Session::flash($type, $message);
        return Redirect::route($route);
    }

    /**
     * end:: handler Response
     */
}
