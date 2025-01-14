<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Attributes as OA;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;

class GenerateRoutesFromOpenApi extends Command
{
    // コマンドのシグネチャと説明
    protected $signature = 'openapi:generate-routes';

    protected $description = 'Generate routes from OpenAPI attributes directly into routes/api.php';

    // 自動生成の対象にしないコントローラのフルクラス名
    protected $ignoreControllers = [
        'App\Http\Controllers\Api\V1\ProtectedFileController',
    ];

    public function handle(): void
    {
        // 走査するディレクトリのパス
        $directory = app_path('Http/Controllers/Api/V1');

        // コントローラクラスのフルクラス名を取得
        $controllerClasses = $this->getControllerClasses($directory);

        // ルートを追加するファイルのパス
        $fileRoutePath = base_path('routes/api.php');
        $originalContent = file_get_contents($fileRoutePath);

        // 新しいルートを生成
        $newRoutes = $this->generateRoutes($controllerClasses);

        // マーカー間の内容を新しいルートで置き換える
        $finalContent = $this->replaceRoutesInFile($originalContent, $newRoutes);
        file_put_contents($fileRoutePath, $finalContent);
        $this->info('Routes generation completed and added to routes/api.php.');
    }

    /**
     * 指定ディレクトリ内のコントローラクラスのフルクラス名を取得
     */
    private function getControllerClasses(string $directory): array
    {
        $controllerClasses = [];
        // ディレクトリ内を再帰的に走査し、ファイルのみを取得
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $file) {
            // コントローラクラスのフルクラス名を取得
            $filePath = $file->getRealPath();
            $relativePath = mb_substr($filePath, mb_strlen(app_path()) + 1);
            $className = strtr(mb_substr($relativePath, 0, mb_strrpos($relativePath, '.')), '/', '\\');
            $fullClassName = 'App\\' . $className;

            // クラスが存在し、かつ対象外クラスではない場合は配列に追加
            if (class_exists($fullClassName) && ! in_array($fullClassName, $this->ignoreControllers, true)) {
                $controllerClasses[] = $fullClassName;
            }
        }

        return $controllerClasses;
    }

    /**
     * コントローラクラスごとにルートを生成するメソッド
     */
    private function generateRoutes(array $controllerClasses): string
    {
        $newRoutes = "Route::prefix('v1')->group(function () {\n";
        $newAuthRoutes = "Route::middleware('auth:sanctum')->prefix('v1')->group(function () {\n";
        foreach ($controllerClasses as $controllerClass) {
            $reflectionClass = new ReflectionClass($controllerClass);
            foreach ($reflectionClass->getMethods() as $method) {
                $attributes = $method->getAttributes();
                foreach ($attributes as $attribute) {
                    $attributeInstance = $attribute->newInstance();
                    $httpMethod = $this->getHttpMethodFromAttribute($attributeInstance);
                    if ($httpMethod && property_exists($attributeInstance, 'path')) {
                        $path = $attributeInstance->path;
                        $methodName = $method->name;
                        $routeString = "    Route::{$httpMethod}('{$path}', '{$controllerClass}@{$methodName}');\n";
                        $requiresAuth = $this->requiresAuthMiddleware($attributeInstance);
                        // セキュリティ属性がある場合はauthミドルウェアを適用
                        if ($requiresAuth) {
                            $newAuthRoutes .= $routeString;
                        } else {
                            $newRoutes .= $routeString;
                        }
                    }
                }
            }
        }
        $newRoutes .= "});\n\n";
        $newAuthRoutes .= "});\n";

        return $newRoutes . $newAuthRoutes;
    }

    /**
     * マーカー間の内容を新しいルートで置き換えるメソッド
     */
    private function replaceRoutesInFile(string $originalContent, string $newRoutes): string
    {
        $startMarker = '// OpenAPI generated routes start';
        $endMarker = '// OpenAPI generated routes end';
        $startPos = mb_strpos($originalContent, $startMarker) + mb_strlen($startMarker);
        $endPos = mb_strpos($originalContent, $endMarker);

        return mb_substr($originalContent, 0, $startPos) . "\n" .
            $newRoutes .
            mb_substr($originalContent, $endPos);
    }

    /**
     * 属性インスタンスからHTTPメソッドを取得するメソッド
     */
    private function getHttpMethodFromAttribute(object $attributeInstance): string
    {
        switch ($attributeInstance) {
            case $attributeInstance instanceof OA\Get:
                return 'get';
            case $attributeInstance instanceof OA\Post:
                return 'post';
            case $attributeInstance instanceof OA\Put:
                return 'put';
            case $attributeInstance instanceof OA\Delete:
                return 'delete';
            default:
                return '';
        }
    }

    /**
     * 認証ミドルウェアが必要かどうかを判定する
     */
    private function requiresAuthMiddleware(object $attributeInstance): bool
    {
        if (property_exists($attributeInstance, 'security') && is_array($attributeInstance->security)) {
            foreach ($attributeInstance->security as $security) {
                if (is_array($security) && array_key_exists('sanctum_token', $security)) {
                    return true;
                }
            }
        }

        return false;
    }
}
