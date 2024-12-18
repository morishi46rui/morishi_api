<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->text('name')->comment('ユーザー名');
        $table->text('email')->unique()->comment('メールアドレス');
        $table->text('password')->nullable()->comment('パスワード');
        $table->text('onetime_password')->nullable()->comment('ワンタイムパスワード');
        $table->timestamp('otp_expiration')->nullable()->comment('ワンタイムパスワードの有効期限');
        $table->smallInteger('login_attempts')->nullable()->comment('ログイン失敗回数');
        $table->timestamp('last_login_datetime')->nullable()->comment('最終ログイン日時');
        $table->timestamp('account_locked_datetime')->nullable()->comment('アカウントロック日時');
        $table->timestamp('email_verified_at')->nullable();
        $table->text('remember_token')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });
    DB::statement('CREATE UNIQUE INDEX user_email_unique ON "users" (email) WHERE deleted_at IS NULL');
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
