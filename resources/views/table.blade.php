<table>
    @if ($data('withHeadings') && ($headings = $data('content')[array_key_first($data('content'))]))
        <thead>
            <tr>
                @foreach ($headings as $heading)
                    <th>{!! $heading !!}</th>
                @endforeach
            </tr>
        </thead>
    @endif

    <tbody>
        @foreach ($data('content') as $row)
            @if ($data('withHeadings') && $loop->first)
                @continue
            @endif

            <tr>
                @foreach ($row as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
