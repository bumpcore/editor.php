<?php

use BumpCore\EditorPhp\Casts\EditorPhpCast;
use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Tests\LaravelTestCase;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

use function Orchestra\Testbench\artisan;

uses(LaravelTestCase::class);

test('Can be rendered in Laravel environment', function($sample) {
    expect(EditorPhp::make($sample)->render())->toBeString();
})->with('sample');

test('Can model casting works with json', function($sample) {
    $model = new class() extends Model
    {
        protected $fillable = [
            'content',
        ];

        protected $casts = [
            'content' => EditorPhpCast::class,
        ];
    };

    $model->content = $sample;

    expect($model->content)->toBeInstanceOf(EditorPhp::class);
})->with('sample');

test('Can model casting works with editor.php instance', function($sample) {
    $model = new class() extends Model
    {
        protected $fillable = [
            'content',
        ];

        protected $casts = [
            'content' => EditorPhpCast::class,
        ];
    };

    $model->content = EditorPhp::make($sample);

    expect($model->content)->toBeInstanceOf(EditorPhp::class);
})->with('sample');

test('Can `make:block` command creates block provider', function() {
	expect(artisan($this, 'make:block FooBlock'))->toEqual(Command::SUCCESS);
});

test('Can render on response', function() {
	$response = $this->get('/editor', ['Accept' => 'text/html'])->getContent();

	expect($response)->not()->toBeJson();
});

test('Can encode to json on response', function() {
	$response = $this->get('/editor', ['Accept' => 'application/json'])->getContent();

	expect($response)->toBeJson();
});
