@extends('admin.layouts.master')

@section('title', 'User List')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">
                                User List
                                (
                                <i class="fa-solid fa-users"></i>
                                <span class="fw-bold ms-1">
                                    {{ count($users) }}
                                </span>
                                )
                            </h2>
                        </div>
                    </div>

                    <div class="table-data__tool-right">
                        <form action="{{ route('admin#userList') }}" method="GET" class="d-flex justify-content-end">
                            @csrf
                            <input type="search" name="searchKey" class="form-control py-2 w-75" value="{{ request('searchKey') }}" placeholder="Search ...">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>

                @if(count($users) != 0)
                    <div class="table-responsive table-responsive-data2 mt-2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <input type="hidden" class="userId" value="{{$user->id}}">
                                    <td class="col-2">
                                        <img src="{{ $user->image != null ? asset('storage/profile/' . $user->image) : asset('image/default_profile.jpg') }}" class="img-thumbnail shadow-sm">
                                    </td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->address}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            <select class="changeRole me-2">
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                            </select>

                                            <button class="item deleteBtn" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-2">
                            {{$users->links()}}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                @else
                    <h3 class="text-secondary text-center mt-5">There is no user !</h3>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptCode')
<script>
    $(document).ready(function() {
        $('.changeRole').change(function() {
            parent = $(this).parents('tr');
            userId = parent.find('.userId').val();
            role = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/user/changeRole',
                data: {
                    'userId': userId,
                    'role': role
                },
                dataType: 'json',
                success: function(response) {
                    location.reload();
                }
            });
        });

        $('.deleteBtn').click(function() {
            parent = $(this).parents('tr');
            userId = parent.find('.userId').val();

            $.ajax({
                type: 'GET',
                url: '/user/delete',
                data: { 'userId' : userId },
                dataType: 'json',
                success: function(response) {
                    location.reload();
                }
            });
        });
    })
</script>
@endsection
