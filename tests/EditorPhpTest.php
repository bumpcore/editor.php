<?php

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Blocks\Paragraph;
use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Parser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

test(
    'Can be initiated with make method',
    fn ($sample) => expect(EditorPhp::make($sample))->toBeInstanceOf(EditorPhp::class)
)->with('valid');

test(
    'Can be initiated',
    fn ($sample) => expect(new EditorPhp($sample))->toBeInstanceOf(EditorPhp::class)
)->with('valid');

test(
    'Can be initiated with make method without input',
    fn () => expect(EditorPhp::make())->toBeInstanceOf(EditorPhp::class)
);

test(
    'Can be initiated without input',
    fn () => expect(new EditorPhp())->toBeInstanceOf(EditorPhp::class)
);

test(
    'Can register block',
    function() {
        EditorPhp::register(['p' => Paragraph::class]);

        expect(Parser::$blocks)->toHaveKey('p');
        expect(Parser::$blocks['p'])->toEqual(Paragraph::class);
    }
);

test(
    'Model can be set',
    fn ($model) => expect(EditorPhp::make()->setModel($model)->model)->toBeInstanceOf(Model::class)->not()->toBeEmpty()
)->with('models');

test(
    'Can be converted to array',
    fn ($sample) => expect(EditorPhp::make($sample)->toArray())->toBeArray()->toHaveKeys(['time', 'blocks', 'version'])
)->with('valid');

test(
    'Can be encoded into json',
    fn ($sample) => expect(EditorPhp::make($sample)->toJson())->toBeJson()
)->with('valid');

test(
    'Can be rendered',
    fn ($sample) => expect(EditorPhp::make($sample)->render())->toBeString(),
)->with('valid');

test(
    'Can be rendered via casting to string',
    fn ($sample) => expect((string) EditorPhp::make($sample))->toBeString(),
)->with('valid');

test(
    'Can be rendered via toHtml',
    fn ($sample) => expect(EditorPhp::make($sample)->toHtml())->toBeString(),
)->with('valid');

test(
    'Can be generate fake data as instance',
    fn () => expect(EditorPhp::fake(true))->toBeInstanceOf(EditorPhp::class)
);

test(
    'Can be generate fake data as json',
    fn () => expect(EditorPhp::fake(false))->toBeJson()
);

test(
    'Can add and use macro',
    function($sample) {
        EditorPhp::macro(
            'getParagraphs',
            fn () => $this->blocks->filter(fn (Block $block) => $block instanceof Paragraph)
        );

        expect(EditorPhp::make($sample)->getParagraphs())->toBeInstanceOf(Collection::class);
    }
)->with('valid');
