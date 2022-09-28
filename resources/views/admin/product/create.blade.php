@extends('admin.layouts.master')

@section('title', 'Create Product')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
      <div class="container-fluid">
          <div class="row">
              <div class="col-3 offset-8">
                  <a href="{{ route('product#list') }}"><button class="btn bg-dark text-white mb-3">Product List</button></a>
              </div>
          </div>

          <div class="col-lg-6 offset-3">
              <div class="card">
                  <div class="card-body">
                      <div class="card-title">
                          <h3 class="text-center title-2">Create Product</h3>
                      </div>

                      <hr>

                    <form action="{{ route('product#create') }}" method="post" enctype="multipart/form-data" novalidate="novalidate">
                        @csrf

                        <div class="form-group">
                            <label class="control-label mb-1">Name</label>
                            <input id="cc-pament" name="productName" type="text" aria-required="true" aria-invalid="false" placeholder="Enter Product ..." value="{{ old('productName') }}" class="form-control
                            @error('productName')
                                is-invalid
                            @enderror">

                            @error('productName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label mb-1">Category</label>
                            <select name="productCategory" class="form-control
                            @error('productCategory')
                                is-invalid
                            @enderror">

                                <option value="">Choose Category ...</option>

                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('productCategory')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label mb-1">Description</label>
                            <textarea name="productDescription" rows="5" placeholder="Enter Description ..." class="form-control 
                            @error('productDescription')
                                is-invalid
                            @enderror">{{ old('productDescription') }}</textarea>

                            @error('productDescription')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label mb-1">Price</label>
                            <input id="cc-pament" name="productPrice" type="number" aria-required="true" aria-invalid="false" placeholder="Enter Price ..." value="{{ old('productPrice') }}" class="form-control
                            @error('productPrice')
                                is-invalid
                            @enderror">

                            @error('productPrice')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label mb-1">Image</label>
                            <input id="cc-pament" name="productImage" type="file" aria-required="true" aria-invalid="false" class="form-control
                            @error('productImage')
                                is-invalid
                            @enderror">

                            @error('productImage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <button id="payment-button" type="submit" class="btn btn-lg btn-dark btn-block">
                                    <span id="payment-button-amount">Create</span>
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