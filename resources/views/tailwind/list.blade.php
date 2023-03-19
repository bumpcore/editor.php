@if ($data('style') === 'ordered')
    <ol class="pl-8 mb-4 list-decimal">
        @foreach ($data('items', []) as $item)
            <li class="mb-1">{!! $item !!}</li>
        @endforeach
    </ol>
@else
    <ul class="pl-8 mb-4 list-disc">
        @foreach ($data('items', []) as $item)
            <li class="mb-1">{!! $item !!}</li>
        @endforeach
    </ul>
@endif
