@extends('admin.layouts.master')

@section('title', 'Message Detail')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="row col-10 offset-1">
                    <div class="card pt-1 mt-2">
                        <div class="card-header bg-white">
                            <h3>
                                <i class="fa-solid fa-clipboard me-2"></i>
                                Message Detail
                            </h3>
                        </div>

                        <div class="card-body fs-5">
                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-user me-3"></i>Name</div>
                                <div class="col">{{$message->user_name}}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-envelope me-3"></i>Email</div>
                                <div class="col">{{$message->user_email}}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-file-lines me-3"></i>Subject</div>
                                <div class="col">{{$message->subject}}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-message me-3"></i>Message</div>
                                <div class="col">{{$message->message}}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col"><i class="fa-solid fa-calendar me-3"></i>Date</div>
                                <div class="col">{{$message->created_at->format('d/M/Y')}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
