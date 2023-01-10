<?php

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Contracts\Provider;
use BumpCore\EditorPhp\Parser;

test('Can not register un implemented provider', function() {
    $provider = new class()
    {
        public function rules(): array
        {
            return [];
        }

        public function render(Data $data): string
        {
            return $data('foo');
        }
    };

    Parser::register([
        $provider::class,
    ]);
})->throws(Exception::class);

test('Can explicitly define provider type', function() {
    $provider = new class() implements Provider
    {
        public $type = 'bar';

        public function rules(): array
        {
            return [];
        }

        public function render(Data $data): string
        {
            return $data('foo');
        }
    };

    Parser::register([
        $provider,
    ]);

    expect(Parser::$providers)->toHaveKeys([$provider->type]);
});
