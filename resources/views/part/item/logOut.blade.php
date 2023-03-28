<div class="modal fade" id="logOutModal" tabindex="-1" aria-labelledby="logOutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="form-action-logout">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="logOutModalLabel">Log out</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to logout ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="width: fit-content">Close</button>
                <button type="submit" class="btn main-btn" style="width: fit-content">Log Out</button>
            </div>
        </div>
    </form>
    
  </div>
</div>


<script>


    $(".modal-logout-show").on("click",()=>{
         $("#logOutModal").modal("show");
    });

    $('.form-action-logout').submit(() =>{
        
        var data_ajax = {
            url:base_url("logout"),
            data:{
                _token:$(".form-action-logout input[name=_token]").val()
            },
            type:"POST"
        };

        $("#main-load").addClass("show");
        action_rest(data_ajax)
        .done((response) => {
            
            if(response.success = true){

               
                localStorage.setItem('alert_success', JSON.stringify(response));
                window.location.replace(base_url());
                

            }


        })
        .fail((jqXHR,textStatus,errorThorwn) => {
            console.log(jqXHR);
        })

        // console.log(data_ajax);

        return false;
    });



</script>
