<?php

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Blocks\Paragraph;

test(
    'Can be initiated',
    fn () => expect(new Paragraph(['text' => 'foo']))->toBeInstanceOf(Block::class),
);

test(
    'Can be converted to array',
    fn () => expect(Paragraph::make(['text' => 'foo'])->toArray())->toBeArray(),
);

test(
    'Can be access data via get method',
    fn () => expect(Paragraph::make(['text' => 'foo'])->get('text'))
        ->toEqual('foo')
);

test(
    'Can be set data via get method',
    fn () => expect(Paragraph::make(['text' => 'foo'])->set('text', 'baz')->get('text'))
        ->toEqual('baz')
);

test(
    'Can be check data exists via has method',
    fn () => expect(Paragraph::make(['text' => 'foo'])->has('text'))->toBeTrue()
);

test(
    'Can be rendered',
    fn () => expect((new Paragraph(['text' => 'foo']))->render())->toBeString(),
);

test(
    'Can be rendered via casting to string',
    fn () => expect((string) (new Paragraph(['text' => 'foo'])))->toBeString(),
);

test(
    'Can be rendered via toHtml',
    fn () => expect(Paragraph::make(['text' => 'foo'])->toHtml())->toBeString(),
);
