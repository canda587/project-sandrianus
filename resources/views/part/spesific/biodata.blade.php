
    <div class="p-3" style="background-color: white;">
                            <div class="row">
                                <div class="col-12">
                                   <div style="font-size: 1.3em;">Biodata</div> 
                                   <hr class="m-0 mt-1 mb-1">
                                </div>
                                <div class="col-12">
                                    <div class="row mb-2">
                                        <div class="col-3 fw-bold">
                                            Email
                                        </div>
                                        <div class="col-8">
                                            : <span class="main-color-dark">{{ $biodata->email }}</span> 
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-3 fw-bold">
                                            Nama
                                        </div>
                                        <div class="col-8">
                                            : {{ $biodata->name }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-3 fw-bold">
                                            Nomor Telpon
                                        </div>
                                        <div class="col-8">
                                            : {{ $biodata->phone_number }}
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="col-12">
                                    <hr class="m-0 mt-1 mb-1">
                                    <div class="row">
                                        <div class="offset-lg-8 col-lg-4">
                                            <button class="btn main-btn" data-bs-toggle="modal" data-bs-target="#biodataModal"">Update Biodata</button>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>


<!-- Modal -->
<div class="modal fade" id="biodataModal" tabindex="-1" aria-labelledby="biodataModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="biodataModalLabel">Update Biodata</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
            <div class="col-12">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" class="form-control" value="{{ $biodata->name }}">
            </div>

            <div class="info" id="name-info"></div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="phone-number" class="form-label">Phone Number</label>
                <input type="text" id="phone-number" class="form-control" value="{{ $biodata->phone_number }}">
            </div>
        </div>

        <div class="info" id="phone-number-info"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: fit-content">Close</button>
        <button type="button" class="action-update-user btn main-btn" data-email="{{ $biodata->email }}" style="width: fit-content">Update</button>
      </div>
    </div>
  </div>
</div>

<script>
    $(".action-update-user").on("click",function(){
        const email = $(this).data("email");
        const name = $("#name").val();
        const phone_number = $("#phone-number").val();


        var data_ajax = {
            url:base_url("self/" + email),
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{
                phone_number:phone_number,
                name:name,
                _method:"PUT"
            },
            type:"POST"
        };

        action_rest(data_ajax)
        .done((response) => {
            localStorage.setItem("alert_success",JSON.stringify(response));
            if(response.is_admin == 1){
                window.location.replace(base_url("admin"));
            }
            else{
                window.location.replace(base_url("user"));     
            }


        })
        .fail((jqXHR,textStatus,errorThorwn) => {
            console.log(jqXHR);
            var data_error = jqXHR.responseJSON.fail;
            var data_success = jqXHR.responseJSON.success;
            var data_message = jqXHR.responseJSON.response;

            $("#form-control").removeClass("is-invalid");
            $(".info").html("");


            alert_show(data_success,data_message);

            if(data_error.name){
                $("#name").addClass("is-invalid");
                $("#name-info").html(input_info(data_success,data_error.name));
            }

            if(data_error.phone_number){
                $("#phone-number").addClass("is-invalid");
                $("#phone-number-info").html(input_info(data_success,data_error.phone_number));
            }
        })
    })


</script>


