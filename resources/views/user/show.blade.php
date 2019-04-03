@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $user->name}} {{ __('detail.')}}</div>

                <div class="card-body">
                    @include("layouts.alert")

                    <table id="user-view" width="100%">
                        <tr>
                            <td>{{__('Name :')}} {{ $user->name}}</td>
                        </tr>
                        <tr>
                            <td>{{__('Email :')}}{{ $user->email}}</td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{route('users')}}" class="btn btn-sm btn-success"> {{__('Back')}} </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
