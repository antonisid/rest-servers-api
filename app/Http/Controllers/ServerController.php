<?php

namespace App\Http\Controllers;

use App\Server;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServerController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {

    }

    /**
     * @param Server $server
     * @return Response
     */
    public function show(Server $server): Response
    {

    }
}
