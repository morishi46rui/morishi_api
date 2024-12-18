<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Response;

// 参考: https://zenn.dev/egstock_inc/articles/4892cb7313bd4e
class ApiValidation
{
    public function handle(Request $request, \Closure $next): Response
    {
        $psr17Factory = new Psr17Factory();
        $psr17HttpFactory = new PsrHttpFactory(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );

        $validatorBuilder = (new ValidatorBuilder())->fromYamlFile(
            base_path('storage/api-docs/api-docs.json')
        );

        // リクエストのバリデーション
        $errorResponse = self::validateRequest($request, $psr17HttpFactory, $validatorBuilder);
        if ($errorResponse !== null) {
            return $errorResponse;
        }

        $response = $next($request);

        // レスポンスのバリデーション
        $errorResponse = self::validateResponse($response, $request, $psr17HttpFactory, $validatorBuilder);
        if ($errorResponse !== null) {
            return $errorResponse;
        }

        return $response;
    }

    /**
     * リクエストのバリデーション
     */
    private function validateRequest(
        Request $request,
        PsrHttpFactory $psr17HttpFactory,
        ValidatorBuilder $validatorBuilder
    ): ?Response {
        $psrRequest = $psr17HttpFactory->createRequest($request);
        $requestValidator = $validatorBuilder->getRequestValidator();
        try {
            $requestValidator->validate($psrRequest);

            return null;
        } catch (\Exception $error) {
            $actual = (string) $psrRequest->getBody();

            return response()->json(['message' => self::errorMessage($error, $actual)], 400);
        }
    }

    /**
     * レスポンスのバリデーション
     */
    private function validateResponse(
        Response $response,
        Request $request,
        PsrHttpFactory $psr17HttpFactory,
        ValidatorBuilder $validatorBuilder
    ): ?Response {
        $psr7Response = $psr17HttpFactory->createResponse($response);
        $responseValidator = $validatorBuilder->getResponseValidator();
        try {
            $responseValidator->validate(
                new OperationAddress(
                    $request->getPathInfo(),
                    mb_strtolower($request->getMethod())
                ),
                $psr7Response
            );

            return null;
        } catch (\Exception $error) {
            $actual = (string) $psr7Response->getBody();

            return response()->json(['message' => self::errorMessage($error, $actual)], 500);
        }
    }

    /**
     * エラー詳細を取得
     */
    private function errorMessage(\Exception $error, string $actual): string
    {
        return sprintf(
            'API validation failed: %s. Actual: %s',
            $error->getMessage(),
            $actual
        );
    }
}
