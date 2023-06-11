<?php

dataset('valid', [
    'valid' => file_get_contents(__DIR__ . '/samples/valid.json'),
]);

dataset('broken', [
    'broken' => file_get_contents(__DIR__ . '/samples/broken.json'),
]);

dataset('unknownType', [
    'sample' => file_get_contents(__DIR__ . '/samples/unknownType.json'),
]);

dataset('unmatchingSchema', [
    'unmatchingSchema' => file_get_contents(__DIR__ . '/samples/unmatchingSchema.json'),
]);
