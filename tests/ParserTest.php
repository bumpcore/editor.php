<?php

use BumpCore\EditorPhp\Exceptions\InvalidInputException;
use BumpCore\EditorPhp\Exceptions\SchemaMismatchException;
use BumpCore\EditorPhp\Exceptions\UnkownBlockException;
use BumpCore\EditorPhp\Parser;
use Carbon\Carbon;
use Illuminate\Support\Collection;

test(
    'Can be initiated',
    fn ($sample) => expect(new Parser($sample))->toBeInstanceOf(Parser::class),
)->with('valid');

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
)->with('unknownType')->throws(UnkownBlockException::class);

test(
    'Throws exception on invalid Json',
    fn ($sample) => new Parser($sample),
)->with('broken')->throws(InvalidInputException::class);

test(
    'Throws exception on un matching schema',
    fn ($sample) => new Parser($sample),
)->with('unmatchingSchema')->throws(SchemaMismatchException::class);
