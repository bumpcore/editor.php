@switch($level)
    @case(1)
        <h1 class="fw-bold mb-3">{!! $text !!}</h1>
    @break

    @case(2)
        <h2 class="fw-bold mb-3">{!! $text !!}</h2>
    @break

    @case(3)
        <h3 class="fw-bold mb-3">{!! $text !!}</h3>
    @break

    @case(4)
        <h4 class="fw-semibold mb-3">{!! $text !!}</h4>
    @break

    @case(5)
        <h5 class="fw-semibold mb-3">{!! $text !!}</h5>
    @break

    @case(6)
        <h6 class="fw-semibold mb-1">{!! $text !!}</h6>
    @break
@endswitch
