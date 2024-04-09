<div class="table-responsive bg-light mb-3 rounded pb-6">
    <table class="table w-full">
        @if ($withHeadings && ($headings = $content[array_key_first($content)]))
            <thead class="text-uppercase bg-light text-gray-700">
                <tr>
                    @foreach ($headings as $heading)
                        <th class="px-4 py-3">{!! $heading !!}</th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody>
            @foreach ($content as $index => $row)
                @if ($withHeadings && array_key_first($content) === $index)
                    @continue
                @endif

                <tr class="bg-white">
                    @foreach ($row as $cell)
                        <td class="fw-semibold px-4 py-3">{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
