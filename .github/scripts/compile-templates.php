<?php

use Illuminate\Contracts\View\ViewCompilationException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

require __DIR__ . '/../../vendor/autoload.php';

class Compiler extends BladeCompiler
{
    protected function compileForeach($expression)
    {
        preg_match('/\( *(.+) +as +(.*)\)$/is', $expression ?? '', $matches);

        if (count($matches) === 0)
        {
            throw new ViewCompilationException('Malformed @foreach statement.');
        }

        $iteratee = trim($matches[1]);

        $iteration = trim($matches[2]);

        return "<?php foreach({$iteratee} as {$iteration}): ?>";
    }

    protected function compileEndforeach()
    {
        return '<?php endforeach; ?>';
    }
}

$compiler = new Compiler(new Filesystem(), __DIR__, false);

foreach (['bootstrap-five', 'tailwind'] as $framework)
{
    foreach (scandir(__DIR__ . '/../../resources/views/' . $framework) as $template)
    {
        if (!str_ends_with($template, '.blade.php'))
        {
            continue;
        }

        $bladePath = __DIR__ . '/../../resources/views/' . $framework . '/' . $template;
        $compiledPath = __DIR__ . '/../../resources/php/' . $framework . '/' . str_replace('.blade.php', '.php', $template);

        file_put_contents(
            $compiledPath,
            $compiler->compileString(file_get_contents($bladePath))
        );
    }
}
