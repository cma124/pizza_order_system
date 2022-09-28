@extends('user.layouts.master')

@section('title', 'User | Password')

@section('totalCart', count($carts))
@section('totalOrder', count($orders))

@section('content')

<div class="main-content mt-5">
    <div class="section__content section__content--p30">
      <div class="container-fluid">
          <div class="col-lg-6 offset-3">
              <div class="card">
                  <div class="card-body">
                      <div class="card-title">
                          <h3 class="text-center title-2">Change Password</h3>
                      </div>

                      <hr>

                        @if(session('changeSuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i>
                                {{ session('changeSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                      <form action="{{ route('user#changePassword') }}" method="post" novalidate="novalidate">
                          @csrf

                          <div class="form-group">
                              <label class="form-label mb-1">Old Password</label>
                              <input name="oldPassword" type="password" aria-required="true" aria-invalid="false" placeholder="Enter Old Password ..." class="form-control

                                @if(session('incorrectPassword'))
                                    is-invalid
                                @endif

                                @error('oldPassword')
                                    is-invalid
                                @enderror">

                                @if(session('incorrectPassword'))
                                    <div class="invalid-feedback">{{ session('incorrectPassword') }}</div>
                                @endif

                                @error('oldPassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                          </div>

                          <div class="form-group">
                              <label class="form-label mb-1">New Password</label>
                              <input name="newPassword" type="password" aria-required="true" aria-invalid="false" placeholder="Enter New Password ..." class="form-control
                              @error('newPassword')
                                is-invalid
                              @enderror">

                              @error('newPassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="form-group">
                              <label class="form-label mb-1">Confirm Password</label>
                              <input name="confirmPassword" type="password" aria-required="true" aria-invalid="false" placeholder="Enter Confirm Password ..." class="form-control
                              @error('confirmPassword')
                                is-invalid
                              @enderror">

                              @error('confirmPassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div>
                              <button id="payment-button" type="submit" class="btn btn-lg btn-dark btn-block">
                                    <i class="fa-solid fa-key me-1"></i>
                                    <span id="payment-button-amount">Change Password</span>
                              </button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>

@endsection
