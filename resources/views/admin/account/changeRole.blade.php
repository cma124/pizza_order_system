@extends('admin.layouts.master')

@section('title', 'Change Role')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
      <div class="container-fluid">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Change Role</h3>
                        </div>

                        <hr>

                        <form action="{{ route('admin#changeRole', $admin->id) }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-4 offset-1">
                                    <div>
                                        @if($admin->image == null)
                                            <img src="{{ asset('image/default_profile.jpg') }}" class="shadow-sm border" />
                                        @else
                                            <img src="{{ asset('storage/' . $admin->image) }}" />
                                        @endif
                                    </div>
                                </div>
    
                                <div class="col-6">   
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input type="text" class="form-control" value="{{ $admin->name }}" disabled readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Role</label>
                                        <select name="role" class="form-control">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
    
                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input type="email" class="form-control" value="{{ $admin->email }}" disabled readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                        <textarea rows="3" class="form-control" disabled readonly>{{ $admin->address }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input type="number" class="form-control" value="{{ $admin->phone }}" disabled readonly>
                                    </div>
                                </div>
                            </div>
    
                            <div class="mx-5 px-3">
                                <button type="submit" class="w-100 btn btn-lg btn-dark d-block mt-4">
                                    Change Role
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