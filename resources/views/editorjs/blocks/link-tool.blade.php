<a class="embed-link" href="{{ $data['link'] }}" target="_blank" rel="nofollow">
    @php $metaImageUrl = $data['meta']['image']['url'] ?? '' @endphp
    @if ($metaImageUrl)
    <img class="embed-link__image" src="{{ $metaImageUrl }}">
    @endif

    <div class="embed-link__title">
        {{ $data['meta']['title'] }}
    </div>

    <div class="embed-link__description">
        {{ $data['meta']['description'] }}
    </div>

    <span class="embed-link__domain">
        {{ parse_url($data['link'], PHP_URL_HOST)}}
    </span>
</a>