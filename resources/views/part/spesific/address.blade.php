
<div class="p-3" style="background-color: white;">
                            <div class="row mb-4">
                                <div class="col-12">
                                   <div style="font-size: 1.3em;">Address</div> 
                                   <hr class="m-0 mt-1 mb-1">
                                </div>

                                @if ($address)
                                  <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <span class="fw-bold">Province</span>
                                            </div>
                                            <div class="col-lg-9">
                                                {{ $address->province_name }}  
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <span class="fw-bold">City</span>
                                            </div>
                                            <div class="col-lg-9">
                                                {{ $address->city_name }}   
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-12">
                                                <div>
                                                    {{ $address->address_detail }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
                                    
                                    
                                    <div class="col-12">
                                        <hr class="m-0 mt-1 mb-1">
                                        <div class="row">
                                          
                                            <div class="offset-lg-9 col-lg-3">
                                                <button class="show-update btn main-btn"  data-bs-toggle="modal" data-bs-target="#regionModal">Update address</button>
                                            </div> 
                                        </div>
                                    </div>
                                @else

                                    <div class="col-12 text-center mt-5 mb-5">
                                        <div class="fs-3 mb-3">
                                            You do not have an address, please add your address
                                        </div>

                                        <button class="show-add btn main-btn" style="width: fit-content" data-bs-toggle="modal" data-bs-target="#regionModal">Add Address</button>

                                    </div>
                                @endif
                            </div>

                          
                        </div>

<div class="modal fade" id="regionModal" tabindex="-1" aria-labelledby="regionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="regionModalLabel">
            Add Address
            
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12 text-center">
                <div class="spinner-border m-5" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" style="width: fit-content" data-bs-dismiss="modal">Close</button>
        <div id="action-btn">

        </div>
        
      </div>
    </div>
  </div>
</div>
