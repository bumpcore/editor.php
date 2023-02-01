<?php

use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Blocks\Paragraph;

test(
    'Can be initiated',
    fn () => expect((new Paragraph(['text' => 'foo'])))->toBeInstanceOf(Block::class),
);

test(
    'Can be converted to array',
    fn () => expect((new Paragraph(['text' => 'foo']))->toArray())->toBeArray(),
);

test(
    'Can be rendered by casting to string',
    fn () => expect((string) (new Paragraph(['text' => 'foo'])))->toBeString(),
);

test(
    'Can be rendered',
    fn () => expect((new Paragraph(['text' => 'foo']))->render())->toBeString(),
);
