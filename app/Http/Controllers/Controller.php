<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function uploadImage(Request $request, $sub_directory)
    {

        if ($request->hasFile('image')) {
            return  $request->getSchemeAndHttpHost() . '/storage/' .$request->file('image')->store("images/$sub_directory", 'public');

        }

    }

}
