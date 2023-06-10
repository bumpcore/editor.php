<ul class="flex flex-col items-start pl-8 gap-1 mb-4">
    @foreach ($data('items', []) as $item)
        <li class="inline-flex justify-center items-center gap-2">
            <span class="bg-gray-100 rounded-full {!! $item['checked'] ? 'text-gray-700' : 'text-gray-400' !!}">
                <svg
                    class="bi bi-check"
                    fill="currentColor"
                    height="24"
                    viewBox="0 0 16 16"
                    width="24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"
                    />
                </svg>
            </span>

            @if ($item['checked'])
                <del>{!! $item['text'] !!}</del>
            @else
                <span>{!! $item['text'] !!}</span>
            @endif
        </li>
    @endforeach
</ul>
