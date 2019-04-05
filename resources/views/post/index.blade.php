@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{__('Post Listing')}}</div>

                <div class="card-body">
                    @include("layouts.alert")
                    <div class="pull-right">
                        <a href="{{route('post.create')}}" class="btn-sm btn btn-primary" style="float:right">{{ __('Create New') }}</a>
                    </div>
                    <table id="post-list" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="10%">id</th>
                                <th width="30%">Title</th>
                                <th width="30%">Created By</th>
                                <th width="30%" class="no-sort" >Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($posts))
                                @foreach($posts as $post)
                                    <tr>
                                        <td>{{ $post->id}}</td>
                                        <td>{{ $post->name}}</td>
                                        <td>{{ $post->user->name}}</td>
                                        <td>
                                            <a href="{{route('post.show',$post->id)}}" class="btn btn-sm btn-primary"> {{__('View')}} </a>
                                            <a href="{{route('post.comment',$post->id)}}" class="btn btn-sm btn-primary"> {{__('Add Comment')}} </a>
                                            @if($post->user_id ==  auth()->user()->id)
                                                <a href="{{route('post.edit',$post->id)}}" class="btn btn-sm btn-success"> {{__('Edit')}} </a>
                                                <a href="javascript:void(0);" data-id="{{route('post.destroy',$post->id)}}" onclick="deleteUser(this);" class="btn btn-sm btn-danger"> {{__('Delete')}} </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="pull-middle"> {{ __("No record found.")}}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery('#post-list').DataTable({
                                    "columnDefs": [ {
                                        "targets": 'no-sort',
                                        "orderable": false,
                                    } ]
                                });
                            jQuery.ajaxSetup({
                                headers: {
                                  'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                }
                            });
                        });

                        function deleteUser(element){
                            if(confirm("Are you sure to delete this record.")){
                                jQuery.ajax({
                                    type: "DELETE",
                                    url: jQuery(element).attr('data-id'),
                                    data:{"id": jQuery(element).attr('id')},
                                    success: function (response) {
                                        if(response.isSuccess =="success"){
                                            alert(response.message);
                                            window.location.reload();
                                        }else{
                                            alert(response.message);
                                        }
                                    },
                                    error: function (err) {
                                        console.log('Error:', err);
                                    }
                                });
                            };
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
