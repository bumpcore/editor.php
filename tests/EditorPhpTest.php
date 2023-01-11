<?php

use BumpCore\EditorPhp\EditorPhp;

test(
    'Can be initiated with make method',
    fn ($sample) => expect(EditorPhp::make($sample))->toBeInstanceOf(EditorPhp::class)
)->with('valid');

test(
    'Can be initiated',
    fn ($sample) => expect(new EditorPhp($sample))->toBeInstanceOf(EditorPhp::class)
)->with('valid');

test(
    'Can be converted to array',
    fn ($sample) => expect(EditorPhp::make($sample)->toArray())->toBeArray()->toHaveKeys(['time', 'blocks', 'version'])
)->with('valid');

test(
    'Can be encoded into json',
    fn ($sample) => expect(EditorPhp::make($sample)->toJson())->toBeJson()
)->with('valid');

test(
    'Can be rendered by casting to string',
    fn ($sample) => expect((string) EditorPhp::make($sample))->toBeString(),
)->with('valid');

test(
    'Can be rendered',
    fn ($sample) => expect(EditorPhp::make($sample)->render())->toBeString(),
)->with('valid');
