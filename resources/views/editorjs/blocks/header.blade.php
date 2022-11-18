@php
    $level = $data['level'] ?? 1;
    $tag = "h{$level}";
@endphp

<{{ $tag }}>{{ $data['text'] ?? '' }}</{{ $tag }}>
