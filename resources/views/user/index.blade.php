@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{__('User Listing')}}</div>

                    <div class="card-body">
                        @include("layouts.alert")
                        <div class="pull-right">
                            <a href="{{route('user.create')}}" class="btn-sm btn btn-primary"
                               style="float:right">{{ __('Create New') }}</a>
                        </div>
                        <table id="user-list" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th width="10%">id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country</th>
                                {{--<th>Total Post of Country</th>--}}
                                <th class="no-sort">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($users))
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id}}</td>
                                        <td>{{ $user->name}}</td>
                                        <td>{{ $user->email}}</td>
                                        <td>{{ $user->country->name}}</td>
                                        {{--<td>{{ $user->country->posts->count() ?? 0}}</td>--}}
                                        <td>
                                            <a href="{{route('user.show',$user->id)}}"
                                               class="btn btn-sm btn-primary"> {{__('View')}} </a>
                                            <a href="{{route('user.edit',$user->id)}}"
                                               class="btn btn-sm btn-success"> {{__('Edit')}} </a>
                                            <a href="javascript:void(0);" data-id="{{route('user.destroy',$user->id)}}"
                                               onclick="deleteUser(this);"
                                               class="btn btn-sm btn-danger"> {{__('Delete')}} </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="pull-middle"> {{ __("No record found.")}}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                        <script type="text/javascript">
                            jQuery(document).ready(function () {
                                jQuery('#user-list').DataTable({
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

                            function deleteUser(element) {
                                if (confirm("Are you sure to delete this record.")) {
                                    jQuery.ajax({
                                        type: "DELETE",
                                        url: jQuery(element).attr('data-id'),
                                        data: {"id": jQuery(element).attr('id')},
                                        success: function (response) {
                                            if (response.isSuccess == "success") {
                                                alert(response.message);
                                                window.location.reload();
                                            } else {
                                                alert(response.message);
                                            }
                                        },
                                        error: function (err) {
                                            console.log('Error:', err);
                                        }
                                    });
                                }
                                ;
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
