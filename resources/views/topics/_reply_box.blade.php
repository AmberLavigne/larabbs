{{--回复话题--}}
@include('common.error')
<div class="reply-box">
    <form action="{{ route('replies.store') }}" method="POST">
        {{ csrf_field() }}
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
        <div class="form-group">
            <textarea class="form-control" name="content" id="" cols="30" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-share"></i>回复</button>
    </form>
</div>
<hr>
