<div>
    @foreach ($data('items') as $item)
        <label style="display: block;">
            <input
                @checked($item['checked'])
                disabled
                type="checkbox"
            />
            <span>{{ $item['text'] }}</span>
        </label>
    @endforeach
</div>
