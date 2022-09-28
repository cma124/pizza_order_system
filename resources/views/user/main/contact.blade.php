@extends('user.layouts.master')

@section('title', 'MyPizza | Contact')

@section('contact-active', 'active')

@section('totalCart', count($carts))
@section('totalOrder', count($orders))

@section('content')

<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Contact Us</span></h2>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form bg-light p-30">
                @if(session('sendSuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-1"></i>
                        {{ session('sendSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('contact#store') }}" method="POST">
                    @csrf
                    <div class="control-group mb-4">
                        <input type="text" class="form-control" name="subject" placeholder="Subject" value="{{ old('subject') }}" />

                        @error('subject')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="control-group mb-4">
                        <textarea class="form-control" rows="8" name="message" placeholder="Message">{{ old('message') }}</textarea>

                        @error('message')
                            <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <div class="bg-light p-30 mb-3">
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>1<sup>th</sup> Street, Yangon, Myanmar</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>mypizza@example.com</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
        </div>
    </div>
</div>

@endsection
