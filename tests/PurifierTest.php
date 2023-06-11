<?php

use BumpCore\EditorPhp\Purifier;

test(
    'Can strip attributes from image',
    fn () => expect(Purifier::stripAttributes('<img src="http://example.com/example.jpeg" alt="caption" class="unwanted">', 'img', ['src', 'alt']))
        ->toEqual('<img src="http://example.com/example.jpeg" alt="caption">')
);

test(
    'Can strip attributes from anchor',
    fn () => expect(Purifier::stripAttributes('<a href="index.html" class="unwanted">index</a>', 'a', ['href']))
        ->toEqual('<a href="index.html">index</a>')
);

test(
    'Can strip div tag',
    fn () => expect(Purifier::stripTags('<div class="unwanted">content <a href="index.html">index</a></div>', ['a']))
        ->toEqual('content <a href="index.html">index</a>')
);
