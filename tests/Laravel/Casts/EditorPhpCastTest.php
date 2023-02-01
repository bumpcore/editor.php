<?php

use BumpCore\EditorPhp\EditorPhp;

test(
    'Casting',
    fn ($model) => expect($model->content)->toBeInstanceOf(EditorPhp::class)
)->with('models');

test(
    'Can modify model from instance',
    function($model) {
        $model->content->model->setAttribute('title', 'Strange...');
        expect($model->content->model->title)->toEqual('Strange...');
    },
)->with('models');

test(
    'Cast can be null',
    fn ($model) => expect($model->content)->toBeNull(),
)->with('emptyContentModel');
