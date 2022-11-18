<a class="editor-embed-link" href="{{ $data['link'] }}" target="_blank" rel="nofollow">
    @php $metaImageUrl = $data['meta']['image']['url'] ?? '' @endphp
    @if ($metaImageUrl)
        <img class="editor-embed-link__image" src="{{ $metaImageUrl }}" alt="">
    @endif

    <div class="editor-embed-link__title">
        {{ $data['meta']['title'] }}
    </div>

    <div class="editor-embed-link__description">
        {{ $data['meta']['description'] }}
    </div>

    <span class="editor-embed-link__domain">
        {{ parse_url($data['link'], PHP_URL_HOST)}}
    </span>
</a>
