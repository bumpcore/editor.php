<?php

use BumpCore\EditorPhp\Casts\EditorPhpCast;
use BumpCore\EditorPhp\EditorPhp;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

use function Orchestra\Testbench\artisan;

test('Can be created', function($sample) {
    expect(new EditorPhp($sample))->toBeInstanceOf(EditorPhp::class);
})->with('sample');

test('Can be created with make', function($sample) {
    expect(EditorPhp::make($sample))->toBeInstanceOf(EditorPhp::class);
})->with('sample');

test('Can be converted to array', function($sample) {
    expect(EditorPhp::make($sample)->toArray())
        ->toBeArray()
        ->toHaveKeys(['time', 'blocks', 'version']);
})->with('sample');

test('Can be encoded into json', function($sample) {
    expect(EditorPhp::make($sample)->toJson())
        ->toBeJson();
})->with('sample');

test('Can be rendered', function($sample) {
    expect(EditorPhp::make($sample)->render())->toBeString();
})->with('sample');

test('Can be rendered by casting to string', function($sample) {
    expect((string) EditorPhp::make($sample)->render())->toBeString();
})->with('sample');

test('Can model casting works with json', function($sample) {
	$model = new class() extends Model {
		protected $fillable = [
			'content'
		];

		protected $casts = [
			'content' => EditorPhpCast::class
		];
	};

	$model->content = $sample;

	expect($model->content)->toBeInstanceOf(EditorPhp::class);
})->with('sample');

test('Can model casting works with editor.php instance', function($sample) {
	$model = new class() extends Model {
		protected $fillable = [
			'content'
		];

		protected $casts = [
			'content' => EditorPhpCast::class
		];
	};

	$model->content = EditorPhp::make($sample);

	expect($model->content)->toBeInstanceOf(EditorPhp::class);
})->with('sample');

