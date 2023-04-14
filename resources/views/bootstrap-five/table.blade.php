<div class="table-responsive rounded mb-3 bg-light pb-6">
    <table class="table w-full">
        @if ($data('withHeadings') && ($headings = $data('content')[array_key_first($data('content'))]))
            <thead class=" text-gray-700 text-uppercase bg-light">
                <tr>
                    @foreach ($headings as $heading)
                        <th class="px-4 py-3">{!! $heading !!}</th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody>
            @foreach ($data('content', []) as $index => $row)
                @if ($data('withHeadings') && array_key_first($data('content')) === $index)
                    @continue
                @endif

                <tr class="bg-white">
                    @foreach ($row as $cell)
                        <td class="px-4 py-3 fw-semibold">{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
