<?php

use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Tests\Laravel\TestCase;

uses(TestCase::class);

test(
    'Can be rendered in Laravel environment',
    fn ($sample) => expect(EditorPhp::make($sample)->render())->toBeString()
)->with('valid');

test(
    'Can render on response',
    fn () => expect($this->get('/', ['Accept' => 'text/html'])->getContent())
        ->not()
        ->toBeJson()
);

test(
    'Can encode to json on response',
    fn () => expect($this->get('/', ['Accept' => 'application/json'])->getContent())
        ->toBeJson()
);
