<?php

use BumpCore\EditorPhp\Block\Data;

test(
    'Can be initiated',
    fn () => expect(new Data(['foo' => 'bar'], '*', ['foo' => 'string']))
        ->toBeInstanceOf(Data::class),
);

test(
    'Can empty on validation fail',
    fn () => expect((new Data(['foo' => 'bar'], '*', ['foo' => 'numeric']))->toArray())
        ->toBeEmpty()
);

test(
    'Can be access data by invoking',
    fn () => expect((new Data(['foo' => 'bar'], '*', ['foo' => 'string']))('foo'))
        ->toEqual('bar'),
);

test(
    'Can be access data by invoking with fallback',
    fn () => expect((new Data(['foo' => 'bar'], '*', ['foo' => 'string']))('bar', 'baz'))
        ->toEqual('baz'),
);

test(
    'Can be access data by get method',
    fn () => expect((new Data(['foo' => 'bar'], '*', ['foo' => 'string']))->get('foo'))
        ->toEqual('bar'),
);

test(
    'Can be access data by get method with fallback',
    fn () => expect((new Data(['foo' => 'bar'], '*', ['foo' => 'string']))->get('bar', 'baz'))
        ->toEqual('baz'),
);

test(
    'Can be set data by get method',
    function() {
        $data = new Data(['foo' => 'bar'], '*', ['foo' => 'string']);
        $data->set('foo', 'baz');

        expect($data->get('foo'))->toEqual('baz');
    },
);

test(
    'Can be check data exists via has method',
    fn () => expect((new Data(['foo' => 'bar'], '*', ['foo' => 'string']))->has('bar'))->toBeFalse()
);

test(
    'Can be converted to array',
    fn () => expect((new Data(['foo' => 'bar'], '*', ['foo' => 'string']))->toArray())->toBeArray(),
);

test(
    'Can allow all tags',
    function() {
        $data = new Data(
            ['foo' => '<script>console.log("Hello!");</script> <div>This should be allowed!</div>'],
            '*',
            ['foo' => 'string']
        );

        expect(str_contains($data->get('foo'), 'div'))->toBeTrue();
        expect(str_contains($data->get('foo'), 'script'))->toBeTrue();
    }
);

test(
    'Can allow only anchor with href attribute',
    function() {
        $data = new Data(
            ['foo' => '<script>console.log("Hello!");</script> <div>This should be not allowed!</div> <a href="http//example.com" class="wowi">This should be allowed</a>'],
            ['foo' => ['a:href']],
            ['foo' => 'string']
        );

        expect(str_contains($data->get('foo'), '<div>'))->toBeFalse();
        expect(str_contains($data->get('foo'), '<script>'))->toBeFalse();
        expect(str_contains($data->get('foo'), '<a href="http//example.com">'))->toBeTrue();
        expect(str_contains($data->get('foo'), '<a href="http//example.com" class="wowi">'))->toBeFalse();
    }
);

test(
    'Can allow every tag for single field',
    function() {
        $data = new Data(
            ['foo' => '<script>console.log("Hello!");</script> <div>This should be not allowed!</div> <a href="http//example.com" class="wowi">This should be allowed</a>'],
            ['foo' => '*'],
            ['foo' => 'string']
        );
        expect(str_contains($data->get('foo'), '<div>'))->toBeTrue();
        expect(str_contains($data->get('foo'), '<script>'))->toBeTrue();
        expect(str_contains($data->get('foo'), '<a href="http//example.com">'))->toBeFalse();
        expect(str_contains($data->get('foo'), '<a href="http//example.com" class="wowi">'))->toBeTrue();
    }
);

test(
    'Can allow all attributes for tag',
    function() {
        $data = new Data(
            ['foo' => '<a href="http//example.com" class="wowi">This should be allowed</a>'],
            ['foo' => 'a:*'],
            ['foo' => 'string']
        );

        expect(str_contains($data->get('foo'), '<a href="http//example.com">'))->toBeFalse();
        expect(str_contains($data->get('foo'), '<a href="http//example.com" class="wowi">'))->toBeTrue();
    }
);
