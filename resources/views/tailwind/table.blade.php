<div class="relative mb-4 overflow-x-auto rounded-xl bg-gray-100 pb-6">
    <table class="table w-full text-left text-sm text-gray-500">
        @if ($withHeadings && ($headings = $content[array_key_first($content)]))
            <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                <tr>
                    @foreach ($headings as $heading)
                        <th class="px-6 py-3">{!! $heading !!}</th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody>
            @foreach ($content as $index => $row)
                @if ($withHeadings && array_key_first($content) === $index)
                    @continue
                @endif

                <tr class="border-b bg-white">
                    @foreach ($row as $cell)
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
