<?php

use BumpCore\EditorPhp\Block;
use BumpCore\EditorPhp\Blocks\Paragraph;
use BumpCore\EditorPhp\Registry;

class BazBlock extends Block
{
    public function render(): string
    {
        return '';
    }
}

class BarBlock extends Block
{
    public function render(): string
    {
        return '';
    }

    public function rules(): array
    {
        return [
            'foo' => 'required|string',
        ];
    }
}

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
    'Can be access data via magic method',
    // @phpstan-ignore-next-line
    fn () => expect(Paragraph::make(['text' => 'foo'])->text)
        ->toEqual('foo')
);

test(
    'Can be set data via get method',
    fn () => expect(Paragraph::make(['text' => 'foo'])->set('text', 'baz')->get('text'))
        ->toEqual('baz')
);

test(
    'Can be set data via magic method',
    function() {
        $paragraph = Paragraph::make(['text' => 'foo']);
        // @phpstan-ignore-next-line
        $paragraph->text = 'baz';
        expect($paragraph->text)->toEqual('baz');
    }
);

test(
    'Can be check data exists via has method',
    fn () => expect(Paragraph::make(['text' => 'foo'])->has('text'))->toBeTrue()
);

test(
    'Can be check data exists via magic method',
    fn () => expect(isset(Paragraph::make(['text' => 'foo'])->text))->toBeTrue()
);

test(
    'Can unset data via magic method',
    function() {
        $paragraph = Paragraph::make(['text' => 'foo']);
        unset($paragraph->text);
        expect($paragraph->has('text'))->toBeFalse();
    }
);

test(
    'Does not sanitizes or validates data by default',
    function() {
        Registry::registerBlock('block', 'BazBlock');

        $block = new BazBlock(['foo' => '<script>alert("foo")</script>']);

        expect($block->get('foo'))->toEqual('<script>alert("foo")</script>');
    }
);

test(
    'Data is empty on invalid data',
    function() {
        Registry::registerBlock('block', 'BarBlock');

        $block = new BarBlock(['foo' => 123]);

        expect($block->get('foo'))->toBeNull();
    }
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
