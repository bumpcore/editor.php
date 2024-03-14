<div class="mb-3 bg-light p-4 rounded">
    <iframe
        class="block mb-3 rounded bg-white"
        height="{!! $height !!}"
        loading="lazy"
        src="{!! $embed !!}"
        width="100%"
    ></iframe>

    <p class="bg-white p-4 rounded mb-1">
        {!! $caption !!}
    </p>

    <p>
        <small>
            <a
                class="link-secondary"
                href="{!! $source !!}"
				target="_blank"
            >{!! $source !!}</a>
        </small>
    </p>

</div>
