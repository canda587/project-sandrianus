@extends('mainPart.authBody')

@section('mainContent')
    
<div class="background background-full" style="background-image: url({{ asset('assets/images/img_situs/background-regis.jpg') }});z-index:1;">

</div>

<div class="slash-background  position-absolute">

</div>


<div class="auth-content regis dark-color shadow" style=" z-index:3; " >
    <div class="ribbon  text-center">
        <div class="font-style-3 " style="font-size: 1.5em;">Registration</div>
        

    </div>
    <form class="form-action-regis">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row pt-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 mb-3"> 
                        <div class="form-floating">
                            <input type="email" class="form-control" id="email" placeholder="name@example.com">
                            <label for="email">Email address</label>
                        </div>

                        <div class="info" id="emailInfo"></div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="name" placeholder="name@example.com">
                            <label for="name">Name</label>
                        </div>

                        <div class="info" id="nameInfo"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-12  mb-3">
               <div class="form-floating">
                    <input type="text" class="form-control" id="phoneNumber" placeholder="name@example.com">
                    <label for="phoneNumber">Phone Number</label>
                </div>

                <div class="info" id="phoneNumberInfo"></div>            
            </div>
    
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6  mb-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" placeholder="name@example.com">
                            <label for="password">Password</label>
                        </div>
                        <div class="info" id="passwordInfo"></div>
                    </div>
                    <div class="col-lg-6  mb-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="confirmPassword" placeholder="name@example.com">
                            <label for="confirmPassword">Confirm Password</label>
                        </div>

                        <div class="info" id="confirmPasswordInfo"></div>    
                    </div>
                </div>
                
            </div>
    
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row">
        
            <div class="col-12 mb-1">
                <button type="submit" class="click-action-regis btn secondary-btn"> Registration </button>
                <hr>
            </div>
            <div class="col-12 mb-1">
               <p>You have a Account ? <a href="/auth" class="text-decoration-none main-color-dark">Login</a></p> 
               <a href="/" class="text-decoration-none third-color-dark"> Back To Home Page </a>
            </div>
            
            
        </div>
    </form>

    
</div>

<script>
 $(document).ready(()=>{

    $('.form-action-regis').submit(() => {
        const _token = $('input[name=_token]').val();
        const email = $('#email').val();
        const name = $('#name').val();
        const phone_number = $('#phoneNumber').val();
        const password = $('#password').val();
        const confirm_password = $('#confirmPassword').val();

        var data_ajax = {
             url:'http://127.0.0.1:8000/regis',
             type:'POST',
             data:{
                 _token : $('input[name=_token]').val(),
                email:$('#email').val(),
                name:$('#name').val(),
                phone_number:$('#phoneNumber').val(),
                password:$('#password').val(),
                confirm_password:$('#confirmPassword').val()
             }
        };
    
        action_rest(data_ajax)
          .done(function(response) {
            //   console.log(response);
               if(response.success == true){
                
                    localStorage.setItem('alert_success', JSON.stringify(response));
                    window.location.replace(base_url('auth'));
              }

        
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);

                var data_error = jqXHR.responseJSON.response;
                var data_message = jqXHR.responseJSON.message;     
                $(".info").html("");
                $('.form-control').removeClass('is-invalid');         
                alert_show(false,data_message);
                
                if(data_error.email){
                    $("#email").addClass('is-invalid');
                    $("#emailInfo").html(input_info(false,data_error.email));
                }

                if(data_error.name){
                    $("#name").addClass('is-invalid');
                    $("#nameInfo").html(input_info(false,data_error.name));
                }

                if(data_error.phone_number){
                    $("#phoneNumber").addClass('is-invalid');
                    $("#phoneNumberInfo").html(input_info(false,data_error.phone_number));
                }

                if(data_error.password){
                    $("#password").addClass('is-invalid');
                    $("#passwordInfo").html(input_info(false,data_error.password));
                }

                if(data_error.confirm_password){
                    $("#confirmPassword").addClass('is-invalid');
                    $("#confirmPasswordInfo").html(input_info(false,data_error.confirm_password));
                }
            });
      

        return false;
    })
 })


</script>
@endsection