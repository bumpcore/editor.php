<?php

use BumpCore\EditorPhp\Block\Data;
use BumpCore\EditorPhp\Blocks\Paragraph;
use BumpCore\EditorPhp\Contracts\Provider;
use BumpCore\EditorPhp\Exceptions\EditorPhpException;
use BumpCore\EditorPhp\Parser;
use Illuminate\Support\Collection;

test(
    'Can be initiated',
    fn ($sample) => expect(new Parser($sample))->toBeInstanceOf(Parser::class),
)->with('valid');

test(
    'Can register provider',
    function() {
        Parser::register([Paragraph::class]);

        expect(Parser::$providers)->toHaveKey(Parser::resolveType(Paragraph::class));
    }
);

test(
    'Can not register un implemented class',
    fn () => Parser::register([(new class()
    {
    })::class])
)->throws(EditorPhpException::class);

test(
    'Can resolves type from given class name',
    fn () => expect(Parser::resolveType('App\Blocks\ParagraphBlock'))->toEqual('paragraph'),
);

test(
    'Can resolves type from given provider',
    fn () => expect(Parser::resolveType(new Paragraph()))->toEqual('paragraph'),
);

test('Can explicitly define provider type', function() {
    $provider = new class() implements Provider
    {
        public $type = 'bar';

        public function rules(): array
        {
            return [];
        }

        public function render(Data $data): string
        {
            return $data('foo');
        }
    };

    Parser::register([
        $provider,
    ]);

    expect(Parser::$providers)->toHaveKeys([$provider->type]);
});

test(
    'Can access time',
    fn ($sample) => expect((new Parser($sample))->time())->toBeNumeric()
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
)->with('unknownProvider')->throws(EditorPhpException::class);

test(
    'Throws exception on invalid Json',
    fn ($sample) => new Parser($sample),
)->with('broken')->throws(EditorPhpException::class);

test(
    'Throws exception on un matching schema',
    fn ($sample) => new Parser($sample),
)->with('unmatchingSchema')->throws(EditorPhpException::class);


