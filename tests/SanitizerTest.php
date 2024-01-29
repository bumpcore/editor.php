<?php

use BumpCore\EditorPhp\Sanitizer;

test(
    'Can ignore sanitization',
    function($data) {
        $sanitizer = new Sanitizer(['text' => $data], '*');

        expect($sanitizer->sanitize()['text'])->toBe($data);
    }
)->with([
    '<a href="https://example.com">foo</a>',
    '<strong>foo</strong>',
    '<script>alert("foo")</script>',
    '<img src="https://example.com/foo.jpg" />',
]);

test(
    'Can sanitize HTML',
    function($data, $expected) {
        $sanitizer = new Sanitizer(
            data: [
                'text' => ['nested' => [$data]],
                'foo' => $data,
            ],
            rules: [
                'text.nested.*' => [
                    'a:href',
                    'strong',
                    'img:src',
                    'i:*',
                ],
                'foo' => '*',
            ]
        );

        expect($sanitizer->sanitize()['text']['nested'][0])->toBe($expected);
        expect($sanitizer->sanitize()['foo'])->toBe($data);
    }
)->with([
    [
        '<a href="https://example.com" title="foo">foo</a>',
        '<a href="https://example.com">foo</a>',
    ],
    [
        '<strong>foo</strong>',
        '<strong>foo</strong>',
    ],
    [
        '<script>alert("foo")</script>',
        '',
    ],
    [
        '<img src="https://example.com/foo.jpg" />',
        '<img src="https://example.com/foo.jpg" />',
    ],
    [
        '<i class="fa fa-foo" title="foo">foo</i>',
        '<i class="fa fa-foo" title="foo">foo</i>',
    ],
]);
