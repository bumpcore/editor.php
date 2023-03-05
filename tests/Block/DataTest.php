<?php

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Block\Field;

test(
    'Can be initiated',
    fn () => expect(new Data(['foo' => 'bar'], [Field::make('foo', 'string')]))
        ->toBeInstanceOf(Data::class),
);

test(
    'Can empty on validation fail',
    fn () => expect((new Data(['foo' => 'bar'], [Field::make('foo', 'numeric')]))->toArray())
        ->toBeEmpty()
);

test(
    'Can be access data by invoking',
    fn () => expect((new Data(['foo' => 'bar'], [Field::make('foo', 'string')]))('foo'))
        ->toEqual('bar'),
);

test(
    'Can be access data by invoking with fallback',
    fn () => expect((new Data(['foo' => 'bar'], [Field::make('foo', 'string')]))('bar', 'baz'))
        ->toEqual('baz'),
);

test(
    'Can be access data by get method',
    fn () => expect((new Data(['foo' => 'bar'], [Field::make('foo', 'string')]))->get('foo'))
        ->toEqual('bar'),
);

test(
    'Can be access data by get method with fallback',
    fn () => expect((new Data(['foo' => 'bar'], [Field::make('foo', 'string')]))->get('bar', 'baz'))
        ->toEqual('baz'),
);

test(
    'Can be set data by get method',
    function()
    {
        $data = new Data(['foo' => 'bar'], [Field::make('foo', 'string')]);
        $data->set('foo', 'baz');

        expect($data->get('foo'))->toEqual('baz');
    },
);

test(
    'Can be check data exists via has method',
    fn () => expect((new Data(['foo' => 'bar'], [Field::make('foo', 'string')]))->has('bar'))->toBeFalse()
);

test(
    'Can be converted to array',
    fn () => expect((new Data(['foo' => 'bar'], [Field::make('foo', 'string')]))->toArray())->toBeArray(),
);
