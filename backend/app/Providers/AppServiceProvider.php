<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // N+1問題を防ぐために、グローバルにEager Loadingを設定
        Model::preventLazyLoading(! app()->isProduction());

        // Passportのクライアント情報を設定(.envから取得する方式に変更するほうが良いかも)
        $secretsPath = base_path('backend/app/secrets/oauth/oauth-private.key');
        if (File::exists($secretsPath)) {
            $secrets = json_decode(File::get($secretsPath), true);
            config([
                'passport.personal_access_client.id' => $secrets['personal_access_client_id'],
                'passport.personal_access_client.secret' => $secrets['personal_access_client_secret'],
                'passport.password_client.id' => $secrets['password_client_id'],
                'passport.password_client.secret' => $secrets['password_client_secret'],
            ]);
        }
    }
}
