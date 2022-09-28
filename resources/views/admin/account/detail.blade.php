@extends('admin.layouts.master')

@section('title', 'Account Details')

@section('content')

<div class="main-content mt-5">
    <div class="section__content section__content--p30">
      <div class="container-fluid">
          <div class="col-lg-10 offset-1">
              <div class="card">
                  <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Account Info</h3>
                        </div>

                        <hr>

                        @if(session('updateSuccess'))
                            <div class="alert alert-success alert-dismissible fade show mx-5" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i>
                                {{ session('updateSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-4 offset-1">
                                @if(Auth::user()->image == null)
                                    <img src="{{ asset('image/default_profile.jpg') }}" class="shadow-sm border" />
                                @else
                                    <img src="{{ asset('storage/profile/' . Auth::user()->image) }}" />
                                @endif
                            </div>

                            <div class="col-7">
                                <p class="ms-2 text-dark fs-5 mb-2">
                                    <i class="fa-solid fa-user me-2"></i>
                                    {{ Auth::user()->name }}
                                </p>

                                <p class="ms-2 text-dark fs-5 mb-2">
                                    <i class="fa-solid fa-envelope me-2"></i>
                                    {{ Auth::user()->email }}
                                </p>

                                <p class="ms-2 text-dark fs-5 mb-2">
                                    <i class="fa-solid fa-location-dot me-2"></i>
                                    {{ Auth::user()->address }}
                                </p>

                                <p class="ms-2 text-dark fs-5 mb-2">
                                    <i class="fa-solid fa-phone me-2"></i>
                                    {{ Auth::user()->phone }}
                                </p>

                                <p class="ms-2 text-dark fs-5">
                                    <i class="fa-solid fa-user-clock me-2"></i>
                                    {{ Auth::user()->updated_at->format('d / M / Y') }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('admin#updatePage') }}" class="d-block btn btn-lg btn-dark mx-5 mt-4">
                            <i class="fa-solid fa-pen-to-square me-2"></i>
                            Edit Profile
                        </a>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>

@endsection
