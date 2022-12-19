@switch($data('level'))
    @case(1)
        <h1>{!! $data('text') !!}</h1>
    @break

    @case(2)
        <h2>{!! $data('text') !!}</h2>
    @break

    @case(3)
        <h3>{!! $data('text') !!}</h3>
    @break

    @case(4)
        <h4>{!! $data('text') !!}</h4>
    @break

    @case(5)
        <h5>{!! $data('text') !!}</h5>
    @break

    @case(6)
        <h6>{!! $data('text') !!}</h6>
    @break
@endswitch
