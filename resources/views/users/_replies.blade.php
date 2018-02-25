@if(count($replies))
    <ul class="list-group">
        @foreach($replies as $reply)
            <li class="list-group-item">
                <a href="{{ $reply->topic->link(['#reply',$reply->id])  }}">
                      {{ $reply->topic->title }}
                </a>
                <div class="reply-content">
                    {!! $reply->content !!}
                </div>
                <div class="meta">
                    <span class="glyphicon glyphicon-time"></span>回复于 {{ $reply->created_at->diffForHumans() }}
                </div>
            </li>
        @endforeach

    </ul>
@else
    <div class="empty-block">暂无数据 ~_~</div>
@endif
{{ $replies->appends(Request::except('page'))->render() }}
