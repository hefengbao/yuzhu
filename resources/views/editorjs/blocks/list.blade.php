@php
$tag = 'ul';
if('ordered' === $data['style']){
$tag = 'ol';
}
@endphp

<{{ $tag }}>
    @foreach($data['items'] as $item)
    <li>{{ $item }}</li>
    @endforeach
</{{ $tag }}>