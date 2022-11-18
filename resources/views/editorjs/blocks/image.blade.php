@php
$classes = '';
if ($data['stretched']){
$classes .= ' image--stretched';
}
if ($data['withBorder']){
$classes .= ' image--bordered';
}
if ($data['withBackground']){
$classes .= ' image--backgrounded';
}
@endphp

<figure class="image {{ $classes }}">
    <img src="{{ $data['file']['url'] }}" alt="{{ $data['caption'] ?: '' }}">
    @if (!empty($data['caption']))
    <footer class="image-caption">
        {{ $data['caption'] }}
    </footer>
    @endif
</figure>