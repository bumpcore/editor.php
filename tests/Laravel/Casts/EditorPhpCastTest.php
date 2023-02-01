<?php

use BumpCore\EditorPhp\EditorPhp;

test(
    'Casting',
    fn ($model) => expect($model->content)->toBeInstanceOf(EditorPhp::class)
)->with('models');

test(
    'Can modify model from instance',
    fn ($model) => expect($model->content->model->setAttribute('title', 'Strange...')->title)->toEqual('Strange...'),
)->with('models');
