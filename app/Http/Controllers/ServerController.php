<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ServerService;
use App\Services\ServerServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ServerController extends Controller
{
    /**
     * @var ServerService
     */
    private $serverService;

    public function __construct(ServerServiceInterface $serverService)
    {
        $this->middleware('jwt.auth');

        $this->serverService = $serverService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $server = $this->serverService->getServers($request->all());

        return response()->json(['items' => $server], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $server = $this->serverService->getServer($id);

        return response()->json(['items' => $server], Response::HTTP_OK);
    }
}
