<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // NOTE: make fixb実行時に"Avoid unused parameters such as '$schedule'"エラーが出たためコメントアウト
        // $this->reportable(function (Throwable $e) {
        //     echo $e;
        // });
    }

    /**
     * 例外をHTTPレスポンスに変換する
     * 例外が発生した際にLaravelによって自動的に呼び出され、例外に基づいた適切なHTTPレスポンスを生成する
     * @psalm-suppress ParamNameMismatch
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            $statusCode = $exception->getStatusCode();
            $message = $exception->getMessage();

            $statusCodes = [
                400 => ['code' => 400, 'message' => 'Bad Request'],
                401 => ['code' => 401, 'message' => 'Unauthorized'],
                404 => ['code' => 404, 'message' => 'Not Found'],
            ];

            if (array_key_exists($statusCode, $statusCodes)) {
                $response = $statusCodes[$statusCode];
                $response['message'] = $message ?: $response['message'];

                return response()->json($response, $statusCode);
            }
        }

        return parent::render($request, $exception);
    }
}
