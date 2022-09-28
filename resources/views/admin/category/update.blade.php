@extends('admin.layouts.master')

@section('title', 'Update Category')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
      <div class="container-fluid">
          <div class="row">
              <div class="col-3 offset-8">
                  <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">Category List</button></a>
              </div>
          </div>

          <div class="col-lg-6 offset-3">
              <div class="card">
                  <div class="card-body">
                      <div class="card-title">
                          <h3 class="text-center title-2">Edit Category</h3>
                      </div>

                      <hr>

                      <form action="{{ route('category#update', $category->id) }}" method="post" novalidate="novalidate">
                          @csrf

                          <div class="form-group">
                              <label for="cc-payment" class="control-label mb-1">Name</label>
                              <input id="cc-pament" name="categoryName" type="text" aria-required="true" aria-invalid="false" placeholder="Enter Category ..." value="{{ old('categoryName', $category->name) }}" class="form-control
                              @error('categoryName')
                                is-invalid
                              @enderror">

                              @error('categoryName')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                          
                          <div>
                              <button id="payment-button" type="submit" class="btn btn-lg btn-dark btn-block">
                                  <span id="payment-button-amount">Edit</span>
                                  <i class="fa-solid fa-circle-right"></i>
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