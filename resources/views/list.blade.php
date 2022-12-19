<p>{!! $data('text') !!}</p>

@if ($data('style') === 'ordered')
    <ol>
        @foreach ($data('items') as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ol>
@else
    <ul>
        @foreach ($data('items') as $item)
            <li>{{ $item }}</li>
        @endforeach
    </ul>
@endif
