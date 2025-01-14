<?php

declare(strict_types=1);

namespace Tests\Unit;

// use App\Models\Kaisou; // テスト対象のモデルをインポート
// use Illuminate\Database\Eloquent\ModelNotFoundException;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Mockery;
// use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SqidTraitTest extends TestCase
{
    // use RefreshDatabase;

    // private $model;

    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     // モックの設定
    //     $this->model = Mockery::mock(Kaisou::class)->makePartial();
    //     $this->model->shouldReceive('getTable')->andReturn('kaisous');
    //     $this->model->id = 1;
    // }

    // #[Test]
    // public function toSqid_idからsqidを取得できる()
    // {
    //     $sqid = $this->model->sqid();

    //     $this->assertNotEmpty($sqid);
    // }

    // #[Test]
    // public function toSqid_指定したカラムの値からsqidを取得できる()
    // {
    //     $sqid = $this->model->toSqid('id', get_class($this->model));

    //     $this->assertNotEmpty($sqid);
    // }

    // #[Test]
    // public function toSqid_存在しないカラム名を指定した場合に空文字を返す()
    // {
    //     $this->assertEmpty($this->model->toSqid('invalid_column', get_class($this->model)));
    // }

    // #[Test]
    // public function findBySqid_無効なsqidを指定した場合にnullが返される()
    // {
    //     $foundModel = Kaisou::findBySqid('invalid-sqid');

    //     $this->assertNull($foundModel);
    // }

    // #[Test]
    // public function findBySqidOrFail_sqidをもとにレコードを取得し存在しない場合は例外がスローされる()
    // {
    //     $this->expectException(ModelNotFoundException::class);
    //     $this->expectExceptionMessage('No query results for model [App\Models\Kaisou].');

    //     Kaisou::findBySqidOrFail(Kaisou::encodeToSqid(99999));
    // }

    // #[Test]
    // public function encodeToSqid_数字のIDを自分のクラスのSQIDとして変換できる()
    // {
    //     $sqid = Kaisou::encodeToSqid(1);

    //     $this->assertNotEmpty($sqid);
    // }

    // #[Test]
    // public function decodeSqid_SQIDを数字のIDに変換できる()
    // {
    //     $sqid = $this->model->sqid();

    //     $decodedId = Kaisou::decodeSqid($sqid);

    //     $this->assertEquals(1, $decodedId);
    // }

    // // テストメソッドの実行後に実行される
    // protected function tearDown(): void
    // {
    //     Mockery::close();
    //     parent::tearDown();
    // }
}
