@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> @if(isset($comment->id) && !empty($comment->id)) {{ __('Edit : ')}} {{ $comment->commentable->name}} @else {{ __('Create New Comment')}} @endif </div>

                    <div class="card-body">
                        @include("layouts.alert")
                        <form method="POST" action="{{ route('post.comment.store') }}" id="post-frm" name="post-frm">
                            @csrf
                            <input type="hidden" name="id" value="{{$comment->id ?? 0}}">
                            <input type="hidden" name="post_id" value="{{$post->id ?? 0}}">
                            <div class="form-group row">
                                <label for="body"
                                       class="col-md-4 col-form-label text-md-right">{{ __('comment') }}</label>

                                <div class="col-md-6">
                                    <textarea id="body" rows="10" cols="20"
                                              class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}"
                                              name="body" required autofocus>{{ $comment->body ??  '' }}</textarea>
                                    @if ($errors->has('body'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        {{ __('Submit') }}
                                    </button>
                                    <a href="{{route('posts')}}" class="btn-sm btn btn-primary">{{ __('Cancel') }}</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
