@extends('admin.layouts.master')

@section('title', 'Update Account')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
      <div class="container-fluid">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Edit Profile</h3>
                        </div>

                        <hr>

                        <form action="{{ route('admin#update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-4 offset-1">
                                    <div>
                                        @if(Auth::user()->image == null)
                                            <img src="{{ asset('image/default_profile.jpg') }}" class="shadow-sm border" />
                                        @else
                                            <img src="{{ asset('storage/profile/' . Auth::user()->image) }}" />
                                        @endif
                                    </div>

                                    <input type="file" name="image" class="form-control mt-4
                                    @error('image')
                                        is-invalid
                                    @enderror">

                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input name="name" type="text" aria-required="true" aria-invalid="false" placeholder="Enter Name ..." value="{{ old('name', Auth::user()->name) }}" class="form-control
                                        @error('name')
                                            is-invalid
                                        @enderror">

                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input name="email" type="email" aria-required="true" aria-invalid="false" placeholder="Enter Email ..." value="{{ old('email', Auth::user()->email) }}" class="form-control
                                        @error('email')
                                            is-invalid
                                        @enderror">

                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                        <textarea name="address" rows="3" class="form-control
                                        @error('address')
                                            is-invalid
                                        @enderror
                                        ">{{ old('address', Auth::user()->address) }}</textarea>

                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input name="phone" type="number" aria-required="true" aria-invalid="false" placeholder="Enter Phone ..." value="{{ old('phone', Auth::user()->phone) }}" class="form-control
                                        @error('phone')
                                            is-invalid
                                        @enderror">

                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mx-5 px-3">
                                <button type="submit" class="w-100 btn btn-lg btn-dark d-block mt-4">
                                    Edit Profile
                                    <i class="fa-solid fa-circle-right ms-1"></i>
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
