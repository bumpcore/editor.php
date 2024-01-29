@if ($style === 'ordered')
    <ol class="mb-3">
        @foreach ($items as $item)
            <li class="mb-1">{!! $item !!}</li>
        @endforeach
    </ol>
@else
    <ul class="mb-3">
        @foreach ($items as $item)
            <li class="mb-1">{!! $item !!}</li>
        @endforeach
    </ul>
@endif
