<p align="center"><img src="art/banner.svg" width="100%"></p>

# Editor.php

Editor.php is a package designed to assist in parsing and manipulating the output of [Editor.js](https://editorjs.io/) with ease. It can be used with either vanilla PHP or with Larave. Laravel offers few additional features.

## Table Of Contents

* [Quick Start](#quick-start)
* [EditorPhp](#editorphp)
  + [Creating Instance](#creating-instance)
  + [Accessing Blocks](#accessing-blocks)
  + [Rendering HTML](#rendering-html)
  + [Faking](#faking)
  + [Additional](#additional)
    + [Converting to an array](#converting-to-an-array)
    + [Converting to JSON](#converting-to-json)
    + [Time & Version](#time--version)
    + [Macros](#macros)
* [Blocks](#blocks)
  + [Registering Blocks](#registering-blocks)
  + [Extending Blocks](#extending-blocks)
  + [Creating Custom Blocks](#creating-custom-blocks)
  + [Accessing Block's Data](#accessing-blocks-data)
  + [Validating Block Data](#validating-block-data)
  + [Sanitizing Block Data](#sanitizing-block-data)
  + [Fake Data Generation](#fake-data-generation)
* [Laravel Only Features](#laravel-only-features)
  + [Cast](#cast)
  + [Response](#response)
  + [Views](#views)
  + [Publishing Views and Configuration](#publishing-views-and-configuration)
  + [Commands](#commands)
* [Contribution](#contribution)
# Quick Start

Install package by:

```bash
composer require bumpcore/editor.php
```

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
$editor->blocks->transform(function(Block $block)
{
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

### Converting to an array 

You can convert your instance to an array using the `toArray()` method.

```php
use BumpCore\EditorPhp\EditorPhp;

$editor = EditorPhp::make($json);

// This will return ['time' => ..., 'blocks' => [...], 'version' => '...']
$array = $editor->toArray();
```

### Converting to JSON

You can convert your instance to JSON using the `toJson(/** options */)` method. This method is useful when you manipulate your instance.

```php
use BumpCore\EditorPhp\EditorPhp;

$editor = EditorPhp::make($json);

// This will return encoded JSON.
$json = $editor->toJson(JSON_PRETTY_PRINT);
```

### Time & Version

You can access time and version:

```php
use BumpCore\EditorPhp\EditorPhp;

$editor = EditorPhp::make($json);

$editor->time;
$editor->version;
```

The `time` property is a `Carbon` instance. You can learn more about it in [Carbon's documentation](https://carbon.nesbot.com/docs/).

### Macros

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

Blocks are the main building parts of the `EditorPhp` editor. You can manipulate them as you wish, and the best part is that you can use them to store your block's logic. For example, the [image](https://github.com/editor-js/image) block requires an uploader to work. You can implement the corresponding functionality in the `BumpCore\EditorPhp\Blocks\Image` class.

## Registering Blocks

Before we jump into learning how to customize blocks, here's how you can register your blocks:

```php
use BumpCore\EditorPhp\EditorPhp;

// This will merge without erasing already registered blocks. Other blocks will still remain with the recently registered `image` and `paragraph` blocks.
EditorPhp::register([
    'image' => \Blocks\MyCustomImageBlock::class,
    'paragraph' => \Blocks\MyCustomParagraphBlock::class,
]);

// This will override already registered blocks. We now only have `image` and `paragraph` blocks.
EditorPhp::register([
    'image' => \Blocks\MyCustomImageBlock::class,
    'paragraph' => \Blocks\MyCustomParagraphBlock::class,
], true);
```

When registering blocks, it's important to use the correct key. The key must be the same as the `Editor.js` 's `type` key. To clarify:

```json
{
    "time": 1672852569662,
    "blocks": [
        {
            "type": "paragraph",
            "data": {
                "text": "..."
            }
        }
    ],
    "version": "2.26.4"
}
```

In this output, our type key is `paragraph` , so we should register it as `'paragraph' => Paragraph::class` . This might vary depending on how you register your blocks in `Editor.js` . Default blocks in `EditorPhp` are registered using `camelCase` .

## Extending Blocks

As mentioned previously, almost all blocks are supported in `EditorPhp` . However, they mostly handle the validation of block data and rendering. For the `Image` block to work properly, it requires an upload. We can implement this upload logic in the `Image` class:

```php
use BumpCore\EditorPhp\Blocks\Image;

class MyImageBlock extends Image
{
    public static function uploadTemp(string $fileName = 'image'): array
    {
        // ...

        // Temporary upload logic.

        return [
            'success' => ...,
            'file' => [
                'url' => ...,
            ],
        ];
    }

    public function upload(): void
    {
        $file = $this->get('file.url');

        // Your logic.

        // ...
        
        // Altering the current block's data.
        $this->set('file.url', ...);
    }
}

// ...

// Registering customized block.
EditorPhp::register([
    'image' => MyImageBlock::class
]);
```

As you can see, we have extended the `Image` block and added two functions to handle our uploads.

The `uploadTemp` function performs a temporary file upload. This method is static and can be used anywhere using `Image::uploadTemp()` . It returns the data required by the [image](https://github.com/editor-js/image) tool.

The `upload` function serves a different purpose. It represents the final upload for the block but is not static. This method assumes that the image has already been uploaded temporarily and the `$json` has been loaded and parsed. Therefore, we can use this function as follows:

```php
use BumpCore\EditorPhp\EditorPhp;
use Blocks\MyImageBlock;

$editor = EditorPhp::make($json);

$editor->blocks->each(function(Block $block)
{
    if ($block instanceof MyImageBlock)
    {
        $block->upload();
    }
});

return $editor->toJson();
```

Now the block performs the final upload and is saved as JSON.

## Creating Custom Blocks

It is impossible to support all blocks out there, so we can implement our own blocks in an easy way. A standard block looks like the following:

```php
use BumpCore\EditorPhp\Block\Block;

class MyCustomBlock extends Block
{
    public function render(): string
    {
        return view('blocks.my-custom-block', ['data' => $this->data]);
    }
}
```

As you can see, by default, we just need to implement the rendering logic. However, there's more than just rendering.

## Accessing Block's Data

There are multiple ways to access a block's data. In the example below, you can see different methods for accessing block data:

```php
public function render(): string
{
    // ...

    // Method 1: Accessing through the data object.
    $data = $this->data;
    $data->get('custom.data');
    $data->set('custom.data', 'Hello World!');

    // Method 2: Accessing by invoking the data object.
    $data('custom.data'); // Hello World!

    // Method 3: Using shortcuts.
    $this->get('custom.data');
    $this->set('custom.data', 'Nice!');

    // ...
}
```

You can choose any of the above methods to access and manipulate the block's data. Additionally, you can also check whether the data exists or not using the following methods:

```php
$data->has('custom.data');
// or
$this->has('custom.data');
```

## Validating Block Data

Validating data is not required, but it can make your data safer. Validating block data is quite easy. We just have to add a `rules` method to our block:

```php
use BumpCore\EditorPhp\Block\Block;

class MyCustomBlock extends Block
{
    // ...

    public function rules(): array
    {
        return [
            'text' => 'required|string|max:255',
            'items' => 'sometimes|array',
            'items.*.name' => 'required|string|max:255',
            'items.*.html' => 'required|string|min:255',
        ];
    }

    // ...
}
```

When validating the block's data fails, the data will be empty. Data validation is performed using Laravel's validation library. You can learn more about it in [Laravel's documentation](https://laravel.com/docs/10.x/validation).

## Sanitizing Block Data

You can purify the HTML of your data if you wish. It's important to prevent injections. Purifying data looks much like validation:

```php
use BumpCore\EditorPhp\Block\Block;

class MyCustomBlock extends Block
{
    // ...

    public function allow(): array|string
    {
        // Specifying one by one.
        return [
            'text' => [
                'a:href,target,title', // Will allow `a` tag and href, target, and title attributes.
                'b', // Will only allow `b` tag with no attributes.
            ],
            'items.*.name' => 'b:*', // Will allow `b` tag with all attributes.
            'items.*.html' => '*', // Will allow every tag and every attribute.
        ];

        // Or just allowing all attributes and tags for all data.
        return '*';
    }

    // ...
}
```

Unlike validation, purifying will only strip unwanted tags and attributes.

## Fake Data Generation

As we mentioned earlier, we can generate fake data with `EditorPhp` . But it requires to generate each block's own fake data. To generate fake data we should add static method to our block:

```php
use BumpCore\EditorPhp\Block\Block;

class MyCustomBlock extends Block
{
    // ...

    public static function fake(\Faker\Generator $faker): array
    {
        $items = [];

        foreach (range(0, $faker->numberBetween(0, 10)) as $index)
        {
            $items[] = [
                'name' => fake()->name(),
                'html' => $faker->randomHtml(),
            ];
        }

        return [
            'text' => fake()->text(255),
            'items' => $items,
        ];
    }

    // ...
}
```

By adding `fake` method to our block, now `EditorPhp` will also include `MyCustomBlock` when generating fake data. You can learn more about at [FakerPHP's documentation](https://fakerphp.github.io/).

# Laravel Only Features

There's few Laravel features that will make your life little bit easier.

## Cast

You can use `EditorPhpCast` to cast your model's attribute to `EditorPhp` instance.

```php
use BumpCore\EditorPhp\Casts\EditorPhpCast;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $casts = [
        'content' => EditorPhpCast::class,
    ];
}

// ...

$post = Post::find(1);

// Content is `EditorPhp` instance in here.
echo $post->content->render();
```

Also if you are using cast, you may access your model within block instances:

```php
use BumpCore\EditorPhp\Block\Block;
use App\Models\Post;

class MyBlock extends Block
{
    // ...

    public static function render(): string
    {
        if($this->root->model instanceof Post)
        {
            // Do the other thing.
        }
    }

    // ...
}
```

You can also alter the model from the block.

## Response

`EditorPhp` instance can be returned as response. If request expects JSON it will encode it self to JSON. Otherwise it will be rendered into html.

```php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;

class ShowPostController extends Controller
{
    public function __invoke(Post $post)
    {
        // Depending on the request it will return json or rendered html.
        return $post->content;
    }
}
```

## Views

You may also use `EditorPhp` instance to render inside view directly:

```blade
{{-- blog.show.blade.php --}}

<article>
    <h1>{{ $post->title }}</h1>
    <div>{{ $post->content }}</div>
</article>
```

## Publishing Views and Configuration

Got to check this before documenting it.

## Commands

You can create brand new block with `block:make <name>` command:

```bash
php artisan make:block CustomImageBlock
```

New block will be placed under `app/Blocks` directory.

# Contribution

Contributions are welcome! If you find a bug or have a suggestion for improvement, please open an issue or create a pull request. Below are some guidelines to follow:

* Fork the repository and clone it to your local machine.
* Create a new branch for your contribution.
* Make your changes and test them thoroughly.
* Ensure that your code adheres to the existing coding style and conventions.
* Commit your changes and push them to your forked repository.
* Submit a pull request to the main repository.

Please provide a detailed description of your changes and the problem they solve. Your contribution will be reviewed, and feedback may be provided. Thank you for your help in making this project better!
