<?php

use BumpCore\EditorPhp\Block\Field;

test(
    'Can be initiated with make method',
    fn () => expect(Field::make('foo', 'string'))->toBeInstanceOf(Field::class),
);

test(
    'Can be initiated',
    fn () => expect(new Field('foo', 'string'))->toBeInstanceOf(Field::class),
);

test(
    'Can be accessed name on given construct',
    fn () => expect(Field::make('foo', 'string')->getName())->toEqual('foo'),
);

test(
    'Can be accessed rules on given construct',
    fn () => expect(Field::make('foo', 'string')->getRules())->toEqual('string'),
);

test(
    'Can be set name',
    fn () => expect(Field::make()->name('foo')->getName())->toEqual('foo'),
);

test(
    'Can be set rules',
    fn () => expect(Field::make()->rules(['string'])->getRules())->toEqual(['string']),
);

test(
    'Can be set allows',
    fn () => expect(Field::make()->allow('img', 'src|alt')->getAllow())->toEqual(['img' => ['src', 'alt']]),
);
