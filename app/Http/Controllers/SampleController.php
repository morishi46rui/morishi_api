<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="My API Documentation",
 *      description="APIの説明文"
 * )
 *
 * @OA\Get(
 *      path="/api/example",
 *      summary="Example API",
 *      description="サンプルのAPIです",
 *      @OA\Response(
 *          response=200,
 *          description="成功"
 *      )
 * )
 */
class SampleController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Example API']);
    }
}
