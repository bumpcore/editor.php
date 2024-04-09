@if ($style === 'ordered')
    <ol class="mb-4 list-decimal pl-8">
        @foreach ($items as $item)
            <li class="mb-1">{!! $item !!}</li>
        @endforeach
    </ol>
@else
    <ul class="mb-4 list-disc pl-8">
        @foreach ($items as $item)
            <li class="mb-1">{!! $item !!}</li>
        @endforeach
    </ul>
@endif
