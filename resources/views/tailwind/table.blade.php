<div class="relative overflow-x-auto rounded-xl mb-4 bg-gray-100 pb-6">
    <table class="table w-full text-sm text-left text-gray-500">
        @if ($data('withHeadings') && ($headings = $data('content')[array_key_first($data('content'))]))
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    @foreach ($headings as $heading)
                        <th class="px-6 py-3">{!! $heading !!}</th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody>
            @foreach ($data('content', []) as $index => $row)
                @if ($data('withHeadings') && array_key_first($data('content')) === $index)
                    @continue
                @endif

                <tr class="bg-white border-b">
                    @foreach ($row as $cell)
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
