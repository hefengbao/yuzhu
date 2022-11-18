@php
$class = '';

if('center' === $data['alignment']) {
$class = 'text-center';
} elseif('left' === $data['alignment']) {
$class = 'text-left';
} else {
$class = 'text-right';
}
@endphp

<blockquote class="editor-quote">
    <p class="{{ $class }}">{{ $data['text'] }}</p>
    @if (!empty($data['caption']))
    <small class="{{ $class }}">— {{ $data['caption'] }}</small>
    @endif
</blockquote>