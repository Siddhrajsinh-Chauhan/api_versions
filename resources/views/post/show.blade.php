@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $post->name}} {{ __('detail.')}}</div>

                <div class="card-body">
                    @include("layouts.alert")

                    <table id="post-view" width="100%">
                        <tr>
                            <td>{{__('Title :')}} {{ $post->name}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Created By :')}}{{ $post->user->name}}</td>
                        </tr>

                        <tr>
                            <td>{{__('Created At :')}}{{ $post->created_at}}</td>
                        </tr>
                        @if($post->comments->count())
                            <tr>
                                <td > <strong>{{__('Comments:')}}</strong>
                                    <ul>
                                        @foreach($post->comments as $comment)
                                            <li style="margin-top: 20px">
                                                {!! $comment->body !!}
                                                <br>
                                                {!! $comment->user->name !!} ( {!! $comment->created_at !!})
                                                @if($comment->user_id ==  auth()->user()->id)
                                                    <a href="{{route('post.comment.edit', $comment->id)}}" class="btn btn-sm btn-success pull-right"> {{__('Edit')}} </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                <a href="{{route('posts')}}" class="btn btn-sm btn-primary"> {{__('Back')}} </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
