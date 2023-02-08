<p>
    @php
    $post = $comment->post;
    @endphp
    <a href="@if($post->type == \App\Constant\PostType::Article->value)
    {{ route('articles.show',$post->slug_id) }}#comment-{{$comment->id}}
    @elseif($post->type == \App\Constant\PostType::Tweet->value)
    {{ route('tweets.show',$post->slug_id) }}#comment-{{$comment->id}}
    @else
    {{ route('pages.show',$post->slug_id) }}#comment-{{$comment->id}}
    @endif" target="_blank">
        @if($comment->user)
            {{ '@'.$comment->user->name }}
        @else
            {{ '@'.$comment->guest_name }}
        @endif
    </a> :
</p>
{!! \Illuminate\Support\Facades\App::make(\App\One\MarkdownToHtml::class)->convert($comment->body) !!}
