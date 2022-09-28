@extends('admin.layouts.master')

@section('title', 'Update Product')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
      <div class="container-fluid">
          <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Edit Product</h3>
                        </div>

                        <hr>

                        <form action="{{ route('product#update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="productId" value="{{ $product->id }}">

                            <div class="row">
                                <div class="col-4 offset-1">
                                    <div>
                                        <img src="{{ asset('storage/products/' . $product->image) }}" />
                                    </div>
    
                                    <input type="file" name="productImage" class="form-control mt-4
                                    @error('productImage')
                                        is-invalid
                                    @enderror">

                                    @error('productImage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
    
                                <div class="col-6">   
                                    <div class="form-group">
                                        <label class="control-label mb-1">Product</label>
                                        <input name="productName" type="text" aria-required="true" aria-invalid="false" placeholder="Enter Product ..." value="{{ old('productName', $product->name) }}" class="form-control
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
                                                <option value="{{ $category->id }}"
                                                @if($category->id == $product->category_id)
                                                    selected
                                                @endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('productCategory')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Description</label>
                                        <textarea name="productDescription" rows="5" class="form-control
                                        @error('productDescription')
                                            is-invalid
                                        @enderror">{{ old('productDescription', $product->description) }}</textarea>

                                        @error('productDescription')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                    <div class="form-group">
                                        <label class="control-label mb-1">Price</label>
                                        <input name="productPrice" type="number" aria-required="true" aria-invalid="false" placeholder="Enter Price ..." value="{{ old('productPrice', $product->price) }}" class="form-control
                                        @error('productPrice')
                                            is-invalid
                                        @enderror">
    
                                        @error('productPrice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label mb-1">Views</label>
                                        <input type="number" class="form-control" value="{{ $product->view_count }}" disabled readonly>
                                    </div>

                                    <div class="form-group">
                                        <div class="control-label mb-1">Created At</div>
                                        <input type="text" class="form-control" value="{{ $product->created_at->format('d-M-Y') }}" disabled readonly>
                                    </div>
                                </div>
                            </div>
    
                            <div class="mx-5 px-3">
                                <button type="submit" class="w-100 btn btn-lg btn-dark d-block mt-4">
                                    Edit Product
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