<?php

namespace IBekzod\Uploader\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function error(String $message = 'Failure', int $status = 400)
    {
        return response()->json([
            'message'   => $message,
        ], $status);
    }

    protected function paginated($resource, $items, $status_code = 200)
    {
        return response()->json([
            'pagination' => [
                'current' => $items->currentPage(),
                'previous' => $items->currentPage() > 1 ? $items->currentPage() - 1 : 0,
                'next' => $items->hasMorePages() ? $items->currentPage() + 1 : 0,
                'perPage' => $items->perPage(),
                'totalPage' => $items->lastPage(),
                'totalItem' => $items->total(),
            ],
            'data' => $resource::collection($items->items())
        ], $status_code);
    }

    protected function singleItem($resource, $item, $status_code = 200)
    {
        return (new $resource($item))->response()->setStatusCode($status_code);
    }
}
