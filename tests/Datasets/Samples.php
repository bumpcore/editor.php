<?php

dataset('sample', [
    'sample' => file_get_contents(__DIR__ . '/sample.json'),
]);

dataset('sampleBroken', [
    'sample' => file_get_contents(__DIR__ . '/sample-broken.json'),
]);

dataset('sampleUnknownProvider', [
    'sample' => file_get_contents(__DIR__ . '/sample-unknown-provider.json'),
]);

dataset('sampleUnmatchingSchema', [
    'sample' => file_get_contents(__DIR__ . '/sample-unmatching-schema.json'),
]);

