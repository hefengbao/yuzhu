@php
    $tag = 'ul';
    if('ordered' === $data['style']){
    $tag = 'ol';
    }
@endphp

<{{ $tag }} class="editor-list">
@foreach($data['items'] as $item)
    <li>{!! $item !!}</li>
@endforeach
</{{ $tag }}>
