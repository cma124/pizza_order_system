@extends('admin.layouts.master')

@section('title', 'Admin List')

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
                                Admin List
                                (
                                <i class="fa-solid fa-users"></i>
                                <span class="fw-bold ms-1">
                                    {{ $admins->total() }}
                                </span>
                                )
                            </h2>

                        </div>
                    </div>

                    <div class="table-data__tool-right">
                        <form action="{{ route('admin#list') }}" method="GET" class="d-flex justify-content-end">
                            @csrf
                            <input type="search" name="searchKey" class="form-control py-2 w-75" value="{{ request('searchKey') }}" placeholder="Search Admin ...">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Update/Delete Successful Message -->
                <div>
                    @if(session('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-check me-1"></i>
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>

                @if(count($admins) != 0)
                    <div class="table-responsive table-responsive-data2 mt-3">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>image</th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>address</th>
                                    <th>phone</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($admins as $admin)
                                    <tr class="tr-shadow">
                                        <input type="hidden" class="adminId" value="{{ $admin->id }}">
                                        <td class="col-2">
                                            @if($admin->image == null)
                                                <img src="{{ asset('image/default_profile.jpg') }}" class="img-thumbnail shadow-sm">
                                            @else
                                                <img src="{{ asset('storage/profile/' . $admin->image) }}" class="img-thumbnail shadow-sm">
                                            @endif
                                        </td>
                                        <td>{{ $admin->name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->address }}</td>
                                        <td>{{ $admin->phone }}</td>
                                        <td>
                                            @if(Auth::user()->id != $admin->id)
                                                <div class="table-data-feature">
                                                    <select class="changeRole me-2">
                                                        <option value="user" @if($admin->role == 'user') selected @endif>User</option>
                                                        <option value="admin" @if($admin->role == 'admin') selected @endif>Admin</option>
                                                    </select>

                                                    <a href="{{ route('admin#delete', $admin->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $admins->links() }}
                    </div>
                    <!-- END DATA TABLE -->
                @else
                    <h3 class="text-secondary text-center mt-5">There is no admin !</h3>
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
            adminId = parent.find('.adminId').val();
            role = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/admin/changeRole',
                data: {
                    'adminId': adminId,
                    'role': role
                },
                dataType: 'json'
            });

            location.reload();
        });
    });
</script>
@endsection
