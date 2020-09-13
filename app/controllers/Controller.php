<?php

namespace App\Controllers;

use App\Libs\Request;
use App\Libs\Response;
use \App\Libs\File;

class Controller
{
    public function index()
    {
        return response()->show("index", [
            'history' => json_decode(File::open('data/search_history.json')->get())
        ]);
    }

    public function handler()
    {
        $searchRequest = Request::post();
        $handledResponse = [];

        try {
            $handledResponse = json_decode(File::open('data/search_history.json')->get());

            if (!strripos(json_encode($handledResponse), $searchRequest->query)) {
                $handledResponse[] = $searchRequest->query;
            }

            File::open('data/search_history.json')->put(json_encode($handledResponse));
        } catch (\Throwable $th) {
            return response()->code(400)->json(['message' => 'Failed request!']);
        }
        

        return response()->code(201)->json($handledResponse);
    }
}

