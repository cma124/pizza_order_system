@extends('admin.layouts.master')

@section('title', 'Message List')

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
                                Message List
                                (
                                <i class="fa-solid fa-database"></i>
                                <span class="fw-bold ms-1">
                                    {{ $messages->total() }}
                                </span>
                                )
                            </h2>

                        </div>
                    </div>

                    <div class="table-data__tool-right">
                        <form action="{{ route('admin#contactList') }}" method="GET" class="d-flex justify-content-end">
                            @csrf
                            <input type="search" name="searchKey" class="form-control py-2 w-75" value="{{ request('searchKey') }}" placeholder="Search ...">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Update/Delete Successful Message -->
                <div>
                    @if(session('message'))
                        <span class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-check me-1"></i>
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </span>
                    @endif
                </div>

                @if(count($messages) != 0)
                    <div class="table-responsive table-responsive-data2 mt-3">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>subject</th>
                                    <th>created at</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($messages as $message)
                                    <tr class="tr-shadow">
                                        <td>{{ $message->user_name }}</td>
                                        <td>{{ $message->user_email }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>
                                            {{ $message->updated_at->format('d-M-Y | n:i A') }}
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('admin#contactDetail', $message->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="View">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin#contactDelete', $message->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $messages->links() }}
                    </div>
                    <!-- END DATA TABLE -->
                @else
                    <h3 class="text-secondary text-center mt-5">There is no message !</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
