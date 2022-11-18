<table class="table">
    @foreach($data['content'] as $row)
    <tr>
        @php $tag = ($loop->first && $data['withHeadings']) ? 'th' : 'td'; @endphp

        @foreach($row as $cell)
        <{{ $tag }}> {{ $cell }} </{{ $tag }}>
        @endforeach
    </tr>
    @endforeach
</table>