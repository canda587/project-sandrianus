@extends('mainPart.mainChildBody')

@section('childContent')
    
<div class="row" id="pageMyAccount">
              <div class="col-lg-3 mb-3">
                    <a href="/admin/items" class="btn third-btn"><i class="fa-solid fa-chevron-left me-2"></i></i>Back To Product Data</a>
                </div>  

                <div class="col-12 mb-3">
                    <div style="font-size: 1.3em;">Form Add Product Data</div>
                    
                    <hr class="m-0 mt-1 mb-1">
                </div>

                <div id="content-form-item" class="col-12">
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <img class="preview-image shadow-sm mb-3" src="{{ asset('assets/images/img_situs/img3.jpg') }}" alt="" style="width: 100%;">
                            <div class="upload-content btn secondary-btn miniText text-decoration-none mb-3" style="width:100%;">
                                <span>Upload Foto</span>
                                <input type="file" name="fotoBaru" id="photo" class="change-image body" onchange="change_image('.upload-content #photo','#content-form-item .preview-image', '#content-form-item #infoPhoto')">
                            </div>

                            <div class="info" id="infoPhoto"></div>
                        </div> 
                        
                        <div class="col-lg-8 mb-3">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="name">Product Name</label>
                                    <form class="action-generate-slug">
                                        <div class="input-group">
                                                <input type="text" class="form-control" id="name">
                                                <button class="btn third-btn" type="submit" id="button-addon2" style="width: fit-content;">
                                                    <i class="fa-solid fa-recycle me-2"></i> 
                                                    Generate Slug
                                                </button>
                                        </div>
                                    </form>

                                    <div class="info" id="infoName"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="slug" class="form-label">Item Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug"   placeholder="This slug will be generated from the item name input" disabled>
                                    <div class="info" id="infoSlug"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select name="" id="category" class="form-control">
                                        <option value="">Choose Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id_category }}">{{ $category->category_name }} </option>
                                        @endforeach
                                    </select>
                                    <div class="info" id="infoCategory"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Product Description</label>
                                    <input id="description" value="" type="hidden" name="content">
                                    <trix-editor input="description" style="min-height: 20rem;"></trix-editor>
                                    <div class="info" id="infoDescription"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                     <label for="stock" class="form-label">Product Weight</label>
                                        <div class="input-group">
                                            <span id="show-weight" class="input-group-text">0 gr</span>
                                            <input type="text" id="weight" class="keyup-number form-control text-lg-center" value="0" data-elemen="#show-weight" data-type="weight">
                                        </div>
                                    <div class="info" id="infoWeight"> </div>   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4  mb-3">
                                    <label for="stock" class="form-label">Product Stok</label>
                                        <div class="input-group">
                                            <span id="show-stock" class="input-group-text">0</span>
                                            <input type="text" id="stock" class="keyup-number form-control text-lg-center" value="0" data-elemen="#show-stock" data-type="number">
                                        </div>
                                    <div class="info" id="infoStock"> </div>

                                </div>
                                <div class="col-lg-8 mb-3">
                                    <label for="price" class="form-label">Product Price</label>
                                    <div class="input-group">
                                            <span id="show-price" class="input-group-text">Rp. 0</span>
                                            <input type="text" id="price" class=" keyup-number form-control" value="0" data-elemen="#show-price" data-type="price">
                                        </div>
                                    <div class="info" id="infoPrice"> </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <hr class="m-0 mb-1 mt-1">
                            
                        </div>
                        <div class="col-12">
                            <div class="row">
                                
                                <div class="offset-lg-9 col-lg-3 mb-2">
                                    <button class="btn main-btn" data-bs-toggle="modal" data-bs-target="#itemModal">
                                        <i class="fa-solid fa-file-pen me-2" ></i>
                                        Add Item Data
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>   
            </div>

{{-- modal component --}}

<div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="itemModalLabel">Add Item Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to add this Data ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: fit-content">Close</button>
        <button type="button" class="action-add-item btn main-btn" style="width: fit-content">Add Data</button>
      </div>
    </div>
  </div>
</div>


{{-- end modal component --}}


@endsection