<p align="center"><img src="art/logo.svg" width="512"></p>

# Editor.php

This package allows you to parse Editor.js output with vanilla PHP or Laravel.

## Table Of Contents

* [Quick Start](#quick-start)
* [EditorPhp](#editorphp)
  + [Creating Instance](#creating-instance)
  + [Accessing Blocks](#accessing-blocks)
  + [Rendering HTML](#rendering-html)
  + [Faking](#faking)
  + [Additional Methods](#additional)
* [Blocks](#blocks)
  + [Creating Custom Blocks](#creating-custom-blocks)
  + [Validating Block Data](#validating-block-data)
  + [Sanitizing Block Data](#sanitizing-block-data)
  + [Fake Data Generation](#fake-data-generation)
* [Laravel Only Features](#laravel-only-features)
  + [Cast](#cast)
  + [Response](#response)
  + [Views](#views)
  + [Configuration](#configuration)
  + [Commands](#commands)
# Quick Start

Editor.php is really simple to get started; 

```php
use BumpCore\EditorPhp\EditorPhp;

// Passing Editor.js's output directly to the `make`.
// This will render blocks into html.
echo EditorPhp::make($json)->render();
```

Editor.php supports following blocks; 

* [Attaches](https://github.com/editor-js/attaches)
* [Checklist](https://github.com/editor-js/checklist)
* [Code](https://github.com/editor-js/code)
* [Delimiter](https://github.com/editor-js/delimiter)
* [Embed](https://github.com/editor-js/embed)
* [Header](https://github.com/editor-js/header)
* [Image](https://github.com/editor-js/image)
* [Link Tool](https://github.com/editor-js/link)
* [List](https://github.com/editor-js/list)
* [Paragraph](https://github.com/editor-js/paragraph)
* [Personality](https://github.com/editor-js/personality)
* [Quote](https://github.com/editor-js/quote)
* [Table](https://github.com/editor-js/table)
* [Warning](https://github.com/editor-js/warning)

All of them have default validation rules and views to render. However, customizing validation and views is highly recommended.

# EditorPhp

The `EditorPhp` class is the main class for managing blocks. You can access, render, convert to an array, and convert to JSON through this class.

## Creating Instance

There are two ways to create a new instance of EditorPhp:

```php
use BumpCore\EditorPhp\EditorPhp;

// Using the `new` syntax.
$editor = new EditorPhp($json);

// Using the `make` syntax.
$editor = EditorPhp::make($json);
```

Both syntaxes are equal, and there's almost no difference between them.

## Accessing Blocks

You can access blocks through the blocks property.

```php
use BumpCore\EditorPhp\EditorPhp;
use BumpCore\EditorPhp\Block\Block;
use BumpCore\EditorPhp\Blocks\Paragraph;

$editor = EditorPhp::make($json);

// Stripping all tags from paragraph block's text.
$editor->blocks->transform(function(Block $block) {
	if($block instanceof Paragraph)
	{
		$block->set('text', strip_tags($block->get('text')));
	}

	return $block;
});
```

Blocks are stored as `Illuminate\Support\Collection` . By using collection methods, you can manipulate blocks as you wish. You can learn about collections in [Laravel's documentation](https://laravel.com/docs/10.x/collections).

## Rendering HTML

Rendering HTML is very straightforward. There are multiple ways to render your instance:

```php
use BumpCore\EditorPhp\EditorPhp;

$editor = EditorPhp::make($json);

// Using the `render` function.
echo $editor->render();

// Using the `toHtml` function.
echo $editor->toHtml();

// Or by casting to a string.
echo $editor;
```

Again, all three cases are the same, with no one above another. You can use whichever one you like the most.

By the default, you have two options for the default block's templates; `tailwindcss` and `Bootstrap 5` . Default used template is `tailwindcss` You may switch templates by:

```php
use BumpCore\EditorPhp\EditorPhp;

// Using tailwind.
EditorPhp::useTailwind();

// Using Bootstrap.
EditorPhp::useBootstrapFive();
```

You can learn more about rendering in [creating custom blocks](#creating-custom-blocks) section.

## Faking

You can generate fake data with `EditorPhp` .

```php
use BumpCore\EditorPhp\EditorPhp; 

// This will return a generated fake JSON.
$fake = EditorPhp::fake(); 

// If we pass first argument true, it will return new `EditorPhp` instance with fake data.
$fakeEditor = EditorPhp::fake(true); 

// You can also pass min lenght and max lenght of blocks.
// Below code will generate blocks between 1 and 3.
$fakeEditor = EditorPhp::fake(true, 1, 3);

echo $fakeEditor->render();
```

You can learn more about generating fake data for the blocks in [fake data generation](#fake-data-generation).

## Additional

#### Converting to an array 

You can convert your instance to an array using the `toArray()` method.

```php
use BumpCore\EditorPhp\EditorPhp;

$editor = EditorPhp::make($json);

// This will return ['time' => ..., 'blocks' => [...], 'version' => '...']
$array = $editor->toArray();
```

#### Converting to JSON

You can convert your instance to JSON using the `toJson(/** options */)` method. This method is useful when you manipulate your instance.

```php
use BumpCore\EditorPhp\EditorPhp;

$editor = EditorPhp::make($json);

// This will return encoded JSON.
$json = $editor->toJson(JSON_PRETTY_PRINT);
```

#### Time & Version

You can access time and version:

```php
use BumpCore\EditorPhp\EditorPhp;

$editor = EditorPhp::make($json);

$editor->time;
$editor->version;
```

The `time` property is a `Carbon` instance. You can learn more about it in [Carbon's documentation](https://carbon.nesbot.com/docs/).

#### Macros

You can register macros and use them later. Macros are based on Laravel.

```php
use BumpCore\EditorPhp\EditorPhp;

// Registering new macro.
EditorPhp::macro(
	'getParagraphs',
	fn () => $this->blocks->filter(fn (Block $block) => $block instanceof Paragraph)
);

$editor = EditorPhp::make($json);

// This will return a collection that only contains paragraphs.
$paragraphs = $editor->getParagraphs();
```

# Blocks

## Creating Custom Blocks

## Validating Block Data

## Sanitizing Block Data

## Fake Data Generation

# Laravel Only Features

## Cast

## Response

## Views

## Configuration

## Commands
