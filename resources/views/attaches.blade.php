<div>
    <a
        download="{{ $data('file.name') }}"
        href="{{ $data('file.url') }}"
    >
        <span>{{ $data('title') ?? $data('file.name') }}</span>
        <small>({{ $data('file.size') * 0.000001 }}MB)</small>
    </a>
</div>
