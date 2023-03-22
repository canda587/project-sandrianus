@extends('mainPart.mainChildBody')

@section('childContent')
{{-- {{ session()->regenerate() }}     --}}
<div class="row" id="pageMyAccount">
    <div class="col-lg-3 mb-3">
        <a href="/admin/categories" class="btn third-btn"><i class="fa-solid fa-chevron-left me-2"></i></i>Back To Categories Data</a>
    </div>
                <div class="col-12 mb-3">
                    <div style="font-size: 1.3em;">Form Update Category Data</div>
                    
                    <hr class="m-0 mt-1 mb-1">
                </div>

                <div class="col-12">
                    <div id="content-form-category" class="row">
                       
                        <div class="col-lg-4 mb-3">
                            <input type="hidden" name="old_image" id="old-image" value="{{ $category->category_image }}">
                            <img class="preview-image shadow-sm mb-3" src="{{asset($category->category_image) }}" alt="" style="width: 100%;">
                            <div class="upload-content btn secondary-btn miniText text-decoration-none mb-3" style="width:100%;">
                                <span>Upload Foto</span>
                                <input type="file" name="fotoBaru" id="photo" class="body"  onchange="change_image('.upload-content #photo','#content-form-category .preview-image', '#content-form-category #infoPhoto')">
                            </div>
                           <div class="info" id="infoPhoto">
                                   
                            </div>
                        </div> 
                        
                        <div class="col-lg-8 mb-3">
                                <div class="mb-3">
                                    <form class="action-generate-slug">
                                        <div class="input-group">
                                                <input type="text" class="form-control" id="name" value="{{ $category->category_name }}">
                                                <button class="btn third-btn" type="submit" id="button-addon2" style="width: fit-content;">
                                                    <i class="fa-solid fa-recycle me-2"></i> 
                                                    Generate Slug
                                                </button>
                                        </div>
                                    </form>
                                    <div class="info" id="infoName"></div>    
                                </div>

                                <div class="mb-3">
                                    
                                    <label for="slug" class="form-label">Category Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug" aria-label="Disabled input example"  placeholder="This slug will be generated from the category name input" value="{{ $category->slug }}" disabled>
                                    <div class="info" id="infoSlug"></div>    
                                </div>
                              
                               
                            </div>
                        
                        <div class="col-12">
                            <hr class="m-0 mb-1 mt-1">
                            
                        </div>
                         <div class="col-12">
                            <div class="row">
                                <div class="offset-lg-6 col-lg-3 mb-2">
                                    <button class="show-category-delete btn fail-btn" data-slug="{{ $category->slug }}">
                                        <i class="fa-solid fa-trash me-2"></i>
                                        Delete Data
                                    </button>
                                </div>
                                <div class="col-lg-3 mb-2">
                                    <button class="show-category-update btn main-btn" data-slug="{{ $category->slug }}">
                                        <i class="fa-solid fa-file-pen me-2"></i>
                                        Update Data
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                    </div>



                </div> 
            </div>



            {{-- modal component --}}

            <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="categoryModalLabel">Delete Category Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form-action-category">
                     <input type="hidden" name="slug" value="{{ $category->slug }}">   
                   
                    <div class="modal-body">
                        Are you sure you want to delete this data ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: fit-content">Close</button>

                        <div id="btn-action">

                        </div>
                       
                    </div>
                </form>
                </div>
            </div>
            </div>
            {{-- end modal component --}}




@endsection