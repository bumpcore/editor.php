<?php

use BumpCore\EditorPhp\Blocks\Paragraph;
use BumpCore\EditorPhp\Exceptions\EditorPhpException;
use BumpCore\EditorPhp\Parser;
use Carbon\Carbon;
use Illuminate\Support\Collection;

test(
    'Can be initiated',
    fn ($sample) => expect(new Parser($sample))->toBeInstanceOf(Parser::class),
)->with('valid');

test(
    'Can register block',
    function() {
        Parser::register(['p' => Paragraph::class]);

        expect(Parser::$blocks)->toHaveKey('p');
        expect(Parser::$blocks['p'])->toEqual(Paragraph::class);
    }
);

test(
    'Can override registered blocks',
    function() {
        Parser::register(['p' => Paragraph::class]);
        expect(Parser::$blocks)->toHaveKey('p');

        Parser::register([], true);
        expect(Parser::$blocks)->not()->toHaveKey('p');
    }
);

test(
    'Can not register un implemented class',
    fn () => Parser::register([(new class()
    {
    })::class])
)->throws(EditorPhpException::class);

test(
    'Can access time',
    fn ($sample) => expect((new Parser($sample))->time())->toBeInstanceOf(Carbon::class)
)->with('valid');

test(
    'Can access blocks',
    fn ($sample) => expect((new Parser($sample))->blocks())->toBeInstanceOf(Collection::class)
)->with('valid');

test(
    'Can access version',
    fn ($sample) => expect((new Parser($sample))->version())->toBeString()
)->with('valid');

test(
    'Throws exception on unknown type',
    fn ($sample) => (new Parser($sample))->blocks(),
)->with('unknownType')->throws(EditorPhpException::class);

test(
    'Throws exception on invalid Json',
    fn ($sample) => new Parser($sample),
)->with('broken')->throws(EditorPhpException::class);

test(
    'Throws exception on un matching schema',
    fn ($sample) => new Parser($sample),
)->with('unmatchingSchema')->throws(EditorPhpException::class);
