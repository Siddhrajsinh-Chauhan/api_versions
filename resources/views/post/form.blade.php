@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> @if(isset($post->id) && !empty($post->id)) {{ __('Edit')}} {{ $post->name}} @else {{ __('Create New')}} @endif </div>

                <div class="card-body">
                    @include("layouts.alert")
                    <form method="POST" action="{{ route('post.store') }}" id="post-frm" name="post-frm">
                        @csrf
                        <input type="hidden" name="id" value="{{$post->id ?? 0}}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $post->name ??  '' }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
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
