<?php

use BumpCore\EditorPhp\Tests\Laravel\TestCase;
use Illuminate\Console\Command;

use function Orchestra\Testbench\artisan;

uses(TestCase::class);

test(
    'Can `make:block` returns success',
    fn () => expect(artisan($this, 'make:block FooBlock'))->toEqual(Command::SUCCESS)
);

