<?php

use BumpCore\EditorPhp\Casts\EditorPhpCast;
use BumpCore\EditorPhp\EditorPhp;
use Illuminate\Database\Eloquent\Model;

$baseModel = new class() extends Model
{
    protected $fillable = [
        'title',
        'content',
    ];

    protected $casts = [
        'content' => EditorPhpCast::class,
    ];
};

dataset('models', [
    'Loads Json' => fn () => $baseModel->fill(['content' => file_get_contents(__DIR__ . '/samples/valid.json')]),
    'Loads Editor.php' => fn () => $baseModel->fill(['content' => EditorPhp::make(file_get_contents(__DIR__ . '/samples/valid.json'))]),
]);

dataset('emptyContentModel', [
    'Empty content' => fn () => $baseModel->fill(['content' => null]),
]);
