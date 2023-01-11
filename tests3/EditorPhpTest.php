<?php

use BumpCore\EditorPhp\EditorPhp;

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
    expect((string) EditorPhp::make($sample))->toBeString();
})->with('sample');

test('Throws exception on broken input', function($sample) {
	EditorPhp::make($sample);
})->with('sampleBroken')->throws(Exception::class);

test('Throws exception on unknown block provider', function($sample) {
	EditorPhp::make($sample);
})->with('sampleUnknownProvider')->throws(Exception::class);

test('Throws exception on unmatching schema', function($sample) {
	EditorPhp::make($sample);
})->with('sampleUnmatchingSchema')->throws(Exception::class);
