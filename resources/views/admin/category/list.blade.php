@extends('admin.layouts.master')

@section('title', 'Category List')

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
                                Category List
                                (
                                <i class="fa-solid fa-database"></i>
                                <span class="fw-bold ms-1">
                                    {{ $categories->total() }}
                                </span>
                                )
                            </h2>

                        </div>
                    </div>

                    <div class="table-data__tool-right">
                        <a href="{{ route('category#createPage') }}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="fa-solid fa-plus"></i>add category
                            </button>
                        </a>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-start">
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

                    <form action="{{ route('category#list') }}" method="GET" class="d-flex justify-content-end">
                        @csrf
                        <input type="search" name="searchKey" class="form-control py-2 w-75" value="{{ request('searchKey') }}" placeholder="Search Category ...">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>

                @if(count($categories) != 0)
                    <div class="table-responsive table-responsive-data2 mt-3">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>category name</th>
                                    <th>created at</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($categories as $category)
                                    <tr class="tr-shadow">
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            {{ $category->updated_at->format('d-M-Y | n:i A') }}
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('category#updatePage', $category->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>

                                                <a href="{{ route('category#delete', $category->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $categories->links() }}
                    </div>
                    <!-- END DATA TABLE -->
                @else
                    <h3 class="text-secondary text-center mt-5">There is no category !</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
