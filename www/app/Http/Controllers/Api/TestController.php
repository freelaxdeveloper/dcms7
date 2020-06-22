<?php


namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class TestController
{
    public function index(Request $request)
    {
        return json_encode(array_merge(
            ['message' => 'Success'],
            $request->toArray()
            )
        );
    }
}