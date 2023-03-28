@extends('mainPart.authBody')

@section('mainContent')


@php
    $error = "";
    $message = "";
    $email = "";
    $password ="";

    if($errors->validate_fail->count() > 0){
        $error = "validate_error";
        $message = "Your input is wrong, please check the Login form again.";
        $email = $errors->validate_fail->first("email");
        $password = $errors->validate_fail->first("password");
    }

    if(session()->has("auth_fail")){
        $error = "auth_error";
        $message = "Wrong Email or Password, if you are not registered, please register first.";
        
    }
    



@endphp



<input type="hidden" value="{{ $error }}" id="typeError">
<input type="hidden" value="{{ $message }}" id="messageError">
<input type="hidden" value="{{ $email }}" id="emailError">
<input type="hidden" value="{{ $password }}" id="passwordError">


<div class="background background-full" style="background-image: url({{ asset('assets/images/img_situs/background-auth.jpg') }});z-index:1;">

</div>

<div class="slash-background auth position-absolute">

</div>




<div class="auth-content auth dark-color shadow" style=" z-index:3; " >
    <div class="auth-body">

        <div class="ribbon text-center">
            <div class="font-style-3" style="font-size: 1.5em;">Login</div>
        </div>
    
        <form class="form-action-autenticate" action="/auth" method="POST">
         
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row pt-3">
                <div class="col-12  mb-3">
                    <div class="form-floating">
                        <input type="email" class="form-control" name="email" id="email" placeholder="email" value="{{ Request::old('email') }}" autocomplete="off" autofocus>
                        <label for="email">Email address</label>
                    </div>
    
                    <div class="info" id="infoEmail"></div>
                </div>
                <div class="col-12 mb-3">
                    <div class="form-floating">
                        <input type="password" class="form-control" name="password" id="password" placeholder="password">
                        <label for="password">Password</label>
                    </div>
    
                    <div class="info" id="infoPassword"></div>
                </div>
        
                <div class="col-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-1">
                    <button type="submit" class="btn main-btn"> Login </button>
                    <hr>
                </div>
                
                <div class="col-12 mb-1">
                   <p>You not ave a Account ? <a href="/regis" class="text-decoration-none second-color-dark">Registration </a></p> 
                   <a href="/" class="text-decoration-none third-color-dark"> Back To Home Page </a>
                </div>
                
            </div>
    
    
        </form>
    </div>


    
</div>
<script>

$(document).ready(() => {
    
    var data_error = $("#typeError").val();
    var message_error = $("#messageError").val();
    console.log(data_error);
    if(data_error == "validate_error"){
       
        var email = $("#emailError").val();
        var password = $("#passwordError").val();
        if(email){
            console.log("email error");
            $(".form-action-autenticate #infoEmail").html(input_info(false,email));
            $(".form-action-autenticate #email").addClass("is-invalid");
        }
        if(password){
            console.log("password error");
            $(".form-action-autenticate #infoPassword").html(input_info(false,password));
            $(".form-action-autenticate #password").addClass("is-invalid");
        }

        alert_show(false,message_error);

    }

    if(data_error == "auth_error"){
       alert_show(false,message_error); 
       $(".form-action-autenticate #email").addClass("is-invalid");
       $(".form-action-autenticate #password").addClass("is-invalid");     
    }



    

    
    
});


</script>
@endsection

