# Editor.php

This package allows you to parse Editor.js output with vanilla PHP or Laravel.

# Usage

Editor.php is really simple to get started; 

```php
use BumpCore\EditorPhp\EditorPhp;

...

// Creating new instance of `EditorPhp`.
// You may also use `new EditorPhp($json)` syntax.
$editorPhp = EditorPhp::make($json);

// This will render blocks into html.
echo $editorPhp->render();
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

All of them has default validation rules and views to render. But customizing validation and views is highly recommended.

# Custom Block

It's possible to create custom blocks with Editor.php. A basic block looks something like this; 

```php
use BumpCore\EditorPhp\Block\Block;

class CustomBlock extends Block
{
    public function rules(): array
    {
        return [
            'custom.data' => 'required|string',
        ];
    }

    public function render(): string
    {
        return view('blocks.custom-block', ['data' => $this->data]);
    }
}

// If you are on Laravel, you may publish config to register blocks.
EditorPhp::register(['customBlock' => CustomBlock::class]);
```

`rules` method is required for validating the block's data. You can learn more about at [Laravel's documentation](https://laravel.com/docs/10.x/validation#available-validation-rules).

`render` method is required for the rendering html. You can return whatever you like to return.

If you are on Laravel, you may use `make:block` command to create empty block. Created block will placed under `app/Blocks` directory.

Also you may customize default views and config by publishing vendors; 

```bash
php artisan vendor:publish --tag=editorphp-config
php artisan vendor:publish --tag=editorphp-views
```

Note that when registering a block, the key should match output type and case. For example; 

```json
{
	"time": 1672852569662,
	"blocks": [
		{
			"type": "customBlock",
			"data": {
				"custom": {
					"data": "Editor.js"
				},
			}
		}
	],
	"version": "2.26.4"
}
```

This will match the block type correctly and when Editor.php converted to Json, Editor.js will also know what this block is.

But if we register type as `customblock` Editor.js will not know which block is that.

# Block Data

As you can see in the above example that we passed `data` directly to the view. You may access data by following ways; 

```php
public function render(): string
{
	...

	// Trough data object.
	$data = $this->data;
	$data->get('custom.data');
	$data->set('custom.data', 'Hello World!');
	

	// Getting by invoking.
	$data('custom.data'); // Hello World!

	// For shortcuts.
	$this->get('custom.data');
	$this->set('custom.data', 'Nice!');

	...
}
```

Also you can check whether data exists or not; 

```php
$data->has('custom.data');
// or
$this->has('custom.data');
```

# Fake Data

You can generate fake data within your block; 

```php
class CustomBlock extends Block
{
	...
	
	public static function fake(\Faker\Generator $faker): array
    {
        return [
			'custom' => [
				'data' => $faker->text()
			]
        ];
    }
}
```

After declaring your generating logic you can use `EditorPhp::fake` method to generate fake data; 

```php
EditorPhp::fake(true) // Will return instance.
```

# Laravel Only Features

## Cast

You can cast your model attribute with `EditorPhpCast` ; 

```php
use BumpCore\EditorPhp\Casts\EditorPhpCast;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	...

	protected $casts = [
		'content' => EditorPhpCast::class
	];
}
```

Now `$post->content` will be `EditorPhp` instance. You can assign `EditorPhp` instance or raw json input.

## Response

`EditorPhp` can be returned directly in the controller method. It will render automatically; 

```php
class PostController extends Controller
{
	public function show(Post $post)
	{
		return $post->content;
	}
}
```

## Views

Like returning in the response you may render `EditorPhp` directly in the views; 

```html
<article>{{ $post->content }}</article>
```
