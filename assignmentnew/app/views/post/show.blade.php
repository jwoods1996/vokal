@extends('layout.master')

<!--Display the parent post-->
@section('singlePost')
<div class='postFeed'>
    <div class='postBox'>
        <div class='postHeader'>
            <div class='postIcon'>             
                <div class='userIcon'>
                    @if (Auth::check() AND $post->user_id == Auth::user()->id)   
                        <img src="{{ asset(Auth::user()->image->url('thumb')) }}">
                    @else
                        <?php $user = User::where('id', $post->user_id)->first(); ?>
                        @if ($user->image)
                            <img src="{{ $user->image->url('thumb') }}">
                        @else
                            <img src="https://s3.amazonaws.com/whisperinvest-images/default.png">
                        @endif
                    @endif
                </div>   
            </div>
            <div class='postDescription'>
                <span class='postTitle'>{{{ $post->title }}}</span></br>
                <span class='postName'>Posted by {{{ $post->name}}}</span>
            </div>
            @if (Auth::check())
            @if ($post->user_id == Auth::user()->id)
            <div class='dropdown postOptions'>
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                  
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        {{ Form::open(array('method' => 'GET', 'action' => array('post.edit', $post->id))) }}
                        {{ Form::submit('Edit', array('class' => 'formButton saveButton')) }}
                        {{ Form::close() }}
                    </li>
                    <li>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('post.destroy', $post->id))) }}
                        {{ Form::submit('Delete', array('class' => 'formButton saveButton')) }}
                        {{ Form::close() }}
                    </li>
                </ul>
            </div>
            @endif
            @endif
        </div>
        <div class='postContent'>
            {{{ $post->message }}}
        </div>
    </div>
</div>
@stop


<!--Display the list of comments-->
@section('comments')
    @foreach($comments as $comment)
        <div class='commentBox'>
            <div class='commentHeader'>
                <div class='commentIcon'>
                <div class='userIcon'>
                    @if (Auth::check() AND $comment->user_id == Auth::user()->id)   
                        <img src="{{ asset(Auth::user()->image->url('thumb')) }}">
                    @else
                        <?php $user = User::where('id', $comment->user_id)->first(); ?>
                        @if ($user->image)
                            <img src="{{ $user->image->url('thumb') }}">
                        @else
                            <img src="https://s3.amazonaws.com/whisperinvest-images/default.png">
                        @endif
                    @endif
                </div>
                </div>   
                <div class='commentDescription'>
                    <span class='commentName'>Posted by {{{ $comment->name}}}</span>
                </div>
                @if (Auth::check())
                @if ($comment->user_id == Auth::user()->id)
                <div class='dropdown postOptions'>
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                      
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        {{ Form::open(array('method' => 'DELETE', 'action' => array('comment.destroy', $comment->id))) }}
                        {{ Form::submit('Delete', array('class' => 'formButton saveButton')) }}
                        {{ Form::close() }}
                      </li>
                    </ul>
                </div>
                @endif
                @endif
            </div>
            <div class='commentContent'>
                {{{ $comment->message }}}
            </div>
        </div>
    @endforeach
    <div class='bottomMessage'>No more comments</div>
    <div class='footer'></div>
@stop


<!--Display the form for adding a comment-->
@section('commentForm')
@if (Auth::check())
    <div class='commentForm'>
        <span class='formTitle'>Add comment..</span>
    {{ Form::open(array('action' => array('comment.store', 'postid' => $post->id, 'userid' => Auth::user()->id))) }}
        <div class='form-fields'>
           <div class="form-title">{{ Form::label('message', 'Message: ') }}</div>
           <span class="form-field">{{ Form::text('message') }}</span><br>
           <span style="color:yellow;font-style:italic;">{{ $errors->first('message') }}</span>
        </div>
        <div class='buttonBar'>
            {{ Form::submit('Post', array('class' => 'formButton saveButton')) }}
        </div>
    {{ Form::close() }}
    </div>
@endif
@stop