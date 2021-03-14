<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return success result
     *
     * @param mixed $result
     * @param string|mixed $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($result, $message = null)
    {
        return response()->json($result, 200);
    }

    /**
     * Return error
     *
     * @param string|mixed $error
     * @param array $data
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($error, $data = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}
