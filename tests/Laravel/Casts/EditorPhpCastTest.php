<?php

use BumpCore\EditorPhp\EditorPhp;

test(
    'Casting',
    fn ($model) => expect($model->content)->toBeInstanceOf(EditorPhp::class)
)->with('models');
