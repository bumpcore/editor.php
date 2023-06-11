<div class="mb-3 bg-light p-4 rounded">
    <iframe
        class="block mb-3 rounded bg-white"
        height="{!! $data('height') !!}"
        loading="lazy"
        src="{!! $data('embed') !!}"
        width="100%"
    ></iframe>

    <p class="bg-white p-4 rounded mb-1">
        {!! $data('caption') !!}
    </p>

    <p>
        <small>
            <a
                class="link-secondary"
                href="{!! $data('source') !!}"
				target="_blank"
            >{!! $data('source') !!}</a>
        </small>
    </p>

</div>
