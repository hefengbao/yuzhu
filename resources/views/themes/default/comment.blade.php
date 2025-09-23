@php
    $comments = $model->comments()->with(['parent','author'])->where('status', \App\Constant\CMS\CommentStatus::Approved)->orderBy('id')->get();
@endphp
<h3>有 {{ $comments->count() }} 条评论</h3>
<div>
    @foreach($comments as $comment)
        <section id="comment-{{ $comment->id }}">
            <div>
                <p>
                    @if($comment->author)
                        @if($comment->author->avatar)
                            <img style="width: 24px; height: 24px; border-radius: 24px"
                                 src="{{ Storage::disk('public')->url($comment->author->avatar)  }}"
                                 alt="">
                        @else
                            <svg width="24px" height="24px" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M8 16L3.54223 12.3383C1.93278 11.0162 1 9.04287 1 6.96005C1 3.11612 4.15607 0 8 0C11.8439 0 15 3.11612 15 6.96005C15 9.04287 14.0672 11.0162 12.4578 12.3383L8 16ZM3 6H5C6.10457 6 7 6.89543 7 8V9L3 7.5V6ZM11 6C9.89543 6 9 6.89543 9 8V9L13 7.5V6H11Z"
                                          fill="#000000"></path>
                                </g>
                            </svg>
                        @endif
                        <strong style="margin: 8px">{{ $comment->author->name }} 说：</strong>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g
                                    id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <style type="text/css">  .st0 {
                                        fill: #000000;
                                    }  </style>
                                <g>
                                    <path class="st0"
                                          d="M179.335,226.703c22.109,0.219,37.484,21.172,44.047,27.047c1.578,1.828,3.875,2.984,6.469,2.984 c4.766,0,8.641-3.859,8.641-8.641c0-2.656-1.219-5.031-3.125-6.609l0.016-0.031c-5-4.781-20.547-25.688-55.734-25.688 s-43.609,26.406-44.5,29.594c-0.016,0.156-0.094,0.297-0.094,0.453c0,1.359,1.078,2.438,2.438,2.438 c1.094,0,1.844-0.875,2.266-1.813C142.491,241.047,150.382,226.406,179.335,226.703z"></path>
                                    <path class="st0"
                                          d="M331.554,216.813c-35.188,0-50.734,20.875-55.734,25.656l0.016,0.047c-1.906,1.578-3.125,3.922-3.125,6.594 c0,4.781,3.875,8.641,8.625,8.641c2.609,0,4.938-1.156,6.516-2.969c6.531-5.891,21.906-26.828,44.016-27.063 c28.953-0.281,36.844,14.344,39.578,19.75c0.422,0.922,1.172,1.797,2.281,1.797c1.344,0,2.422-1.094,2.422-2.422 c0-0.172-0.063-0.328-0.094-0.469C375.163,243.188,366.741,216.813,331.554,216.813z"></path>
                                    <path class="st0"
                                          d="M331.054,370.563l-36.141-2.063l-17.172-10.781c0,0-10.031,5.922-12.328,7.297h-9.094h-9.094 c-2.297-1.375-12.297-7.297-12.297-7.297l-0.375,0.234c-0.266-0.25-0.438-0.563-0.75-0.797c-3.25-2.344-5.047-4.656-4.906-6.313 c0.297-3.438,6.609-8.219,11.063-10.391l4.141-1.953v-50.094c0-9.156-6.094-18.391-17.594-26.688 c-12.266-8.844-30.875-16.375-41.094-12.953c-3.781,1.25-5.797,5.297-4.547,9.078c1.188,3.781,5.344,5.875,9.109,4.688 c3.156-0.953,16.75,2.641,28.5,11.313c6.969,5.109,11.094,10.547,11.094,14.563v41.266c-5.438,3.375-14.25,10.281-15.125,19.859 c-0.375,4.25,0.719,10.313,7.297,16.469l-4,2.5l-36.156,2.063c0,0-36.203-28.922-40.297-34.813l24.578,58.234 c0,0,64.594,0.906,67.234,0.609c12.313-10.016,23.219-21.391,23.219-21.391s10.906,11.375,23.203,21.391 c2.656,0.297,67.25-0.609,67.25-0.609l24.563-58.234C367.257,341.641,331.054,370.563,331.054,370.563z"></path>
                                    <path class="st0"
                                          d="M181.772,319.344c20.031,0,32.766-16.594,32.766-22.219s-12.734-22.203-32.766-22.203 s-32.781,16.578-32.781,22.203S161.741,319.344,181.772,319.344z"></path>
                                    <path class="st0"
                                          d="M325.335,319.344c20.031,0,32.781-16.594,32.781-22.219s-12.75-22.203-32.781-22.203 s-32.766,16.578-32.766,22.203S305.304,319.344,325.335,319.344z"></path>
                                    <path class="st0"
                                          d="M482.46,167.234l-88.891-22.219c0,0-11-76.734-12.781-89.219c-1.766-12.453-12.484-46.344-51.703-46.344 H182.897c-39.188,0-49.906,33.891-51.703,46.344c-1.734,12.484-12.75,89.219-12.75,89.219l-88.922,22.219 c-37.766,8.906-39.344,34.719-4.453,34.719c10.688,0,38.25,0,70.734,0c-14.891,42.609-48.75,141.25-73.266,227.125L69.022,419 v58.594l46.484-22.219l18.188,42.438l21.406-42.844c28.813,31.219,65.484,47.578,101.219,47.578 c36.109,0,72.266-14.031,100.656-43.172l19.25,38.438l18.188-42.438l46.469,22.219V419l46.484,10.078 c-24.547-85.875-58.375-184.516-73.266-227.125c33.391,0,61.906,0,72.813,0C521.819,201.953,520.257,176.141,482.46,167.234z M387.46,297.5c0,120.625-61.375,176.75-124.359,180.484l28.359-43.953h-36.406h-36.422l28.219,43.734 c-60.625-5.938-121.688-68.625-121.703-180.656c-1.297-40.516,4.797-72.406,17.969-95.156c57.219,0,112.891,0,112.891,0 s56.063,0,113.5,0C382.694,224.672,388.788,256.594,387.46,297.5z"></path>
                                </g>
                            </g></svg>
                        <strong style="margin: 8px">{{ $comment->guest_name }} 说：</strong>
                    @endif
                </p>
                @if($comment->parent && $comment->parent->status == \App\Constant\CommentStatus::Approved)
                    <div style="margin:32px;">
                        <blockquote>
                            <p>
                                <a class="link-secondary"
                                   href="{{ url()->current() }}#comment-{{ $comment->parent->id }}">{{ '@' }}{{ $comment->parent->author ? $comment->parent->author->name : $comment->parent->guest_name }}</a>
                            </p>
                            {!! \Illuminate\Support\Str::markdown($comment->parent->body, ['html_input' => 'strip','allow_unsafe_links' => false]) !!}
                        </blockquote>
                    </div>
                @endif
                <div style="margin:0 32px;">
                    {!! \Illuminate\Support\Str::markdown($comment->body, ['html_input' => 'strip','allow_unsafe_links' => false]) !!}
                </div>
                <p style="margin:0 32px; font-style: italic">
                    <small>{{ $comment->created_at->diffForHumans() }}</small> ·
                    <a href="{{ url()->current() }}#respond" rel="nofollow"
                       data-postid="{{ $model->id }}"
                       onclick="reply({{ $comment->id }},'{{ $comment->author ? $comment->author->name : $comment->guest_name }}')">
                        <small>回复</small></a>
                </p>
                <hr style="border-style: dashed">
            </div>
        </section>
    @endforeach
</div>
@if($model->commentable == \App\Constant\CMS\Commentable::Open)
    <h3 id="reply-title">发表评论</h3>
    <p>@auth
            <a href="{{ route('filament.admin.resources.users.edit', auth()->id()) }}">已登录为{{ auth()->user()->name }}</a>
            <a href="#">注销？</a>
        @endauth @guest
            您的电子邮箱地址不会被公开。
        @endguest 必填项已用 * 标注</p>
    <form id="comment-form" action="{{ route('comments.store', $model->slug_id) }}" method="POST">
        <fieldset>
            @csrf
            <input type="hidden" name="parent" id="parent">
            <label for="editor">评论*</label>
            <textarea id="editor" name="body" aria-label="写评论..." required>{{ old('body') }}</textarea>
            @guest
                <label for="name">显示名称*</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                <label for="email">电子邮箱*</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @endguest
        </fieldset>
        <button id="submit" type="submit">发表评论</button>
    </form>
    <script type="text/javascript">
        let replyTitle = document.getElementById('reply-title')
        let parent = document.getElementById('parent')

        function reply(commentId, commentAuthor) {
            replyTitle.innerHTML = "回复<a class='link-secondary' href='{{ url()->current() }}#comment-"
                + commentId
                + "'>"
                + commentAuthor
                + "</a>&nbsp;&nbsp;<small><a class='link-secondary' href='{{ url()->current() }}#respond' onclick='cancelReply()'>取消回复<small>"

            parent.value = commentId
        }

        function cancelReply() {
            parent.value = null
            replyTitle.innerHTML = '发表评论'
        }
    </script>
@endif
