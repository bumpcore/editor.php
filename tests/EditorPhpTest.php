<?php

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Blocks\Paragraph;
use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Registry;
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

        expect(Registry::getBlocks())->toHaveKey('p');
        expect(Registry::getBlockByType('p'))->toEqual(Paragraph::class);
    }
);

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
    'can be rendered either with Bootstrap template or Tailwind template',
    function($sample) {
        EditorPhp::useBootstrapFive();
        expect(EditorPhp::make($sample)->render())->toBeString();
        EditorPhp::useTailwind();
        expect(EditorPhp::make($sample)->render())->toBeString();
    }
)->with('valid');

test(
    'Can be generate fake data as instance',
    fn () => expect(EditorPhp::fake(true, 30, 60))->toBeInstanceOf(EditorPhp::class)
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

test(
    'Can handle dynamic property',
    function() {
        $editor = EditorPhp::make();

        // @phpstan-ignore-next-line
        $editor->foo = 'bar';
        // @phpstan-ignore-next-line
        $editor->baz = 'qux';

        expect($editor->foo)->toEqual('bar');
        expect($editor->baz)->toEqual('qux');

        expect(isset($editor->foo))->toBeTrue();
        expect(isset($editor->bar))->toBeFalse();

        unset($editor->foo, $editor->baz, $editor->bar);



        // @phpstan-ignore-next-line
        expect($editor->foo)->toBeNull();
        // @phpstan-ignore-next-line
        expect($editor->baz)->toBeNull();
    }
);