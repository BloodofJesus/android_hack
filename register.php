<?php

  session_start();
  if(!isset($_SESSION["user_name"]))
    header("location: index.php");
  if($_SESSION["user_name"]!=="super_admin")
    header("location: index.php");
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Android Exploit Tool</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.css" >
    <link rel="stylesheet" type="text/css" href="./css/theme.css" >
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/md5.js"></script>
  </head>
  <body class="main-bg">
    <p class="text-primary" style="float:right">earthshakira</p>
    <div class="container main-bg">
      <div class="well login">
        <h3 class="text-default text-center">Android Exploit Tool</h3>
        <img src="./img/logo.jpg" class="main-logo"/>
        <div class="form-group">
        <label>Username</label>
          <input type="email" class="form-control" placeholder="Enter the hacker name" id="user_name">
        </div>
        <div class="form-group">
          <label>Enter a Password</label>
          <input type="password" class="form-control" placeholder="Password" id="password">
        </div>
        <div class="form-group">
          <label>Re-Enter the Password</label>
          <input type="password" class="form-control" placeholder="Repeat Password" id="re_password">
        </div>
        <div class="form-group">
        <label>Admin key</label>
          <input type="password" class="form-control" placeholder="Adminkey" id="admin_key">
        </div>
        <div class="alert alert-success" style="display:none;margin:20px" id="response">
          <p>
            <strong id="status">Done</strong>
            <span id="message">Added</span>
          </p>
        </div>
        <button class="btn btn-warning center" id="submit">Add User</button>
      </div>
      <script type="text/javascript">

      var cname="";

        $(document).ready(function(){
          $("#submit").click(function(){
            var user=$("#user_name").val();
            var pass=$("#password").val();
            var repass=$("#re_password").val();
            var key=$("#admin_key").val();
            $("#response").removeClass(cname);
            $("#response").addClass("alert-warning");
            cname="alert-warning";
            $("#status").html("Missing");
            if(user.length==0){
              $("#message").html("Please enter a Username");
              $("#response").slideDown('fast');
              return;
            }
            if(pass.length==0){
              $("#message").html("Please enter a Password");
              $("#response").slideDown('fast');
              return;
            }
            if(repass.length==0){
              $("#message").html("Please enter the Repeat Password");
              $("#response").slideDown('fast');
              return;
            }
            if(repass!=pass){
              $("#message").html("Both Passwords Dont Match");
              $("#response").slideDown('fast');
              return;
            }
            if(key.length==0){
              $("#message").html("Please an Admin Key");
              $("#response").slideDown('fast');
              return;
            }
            pass=md5(pass);
            key=md5(key);
            $("html").css("cursor", "progress");
            var formdata={"key":key,"user":user,"pass":pass};
            $("#response").removeClass(cname);
            $.post( "./db/new_user.php",formdata)
                .done(function(data) {
                  console.log(data);
                  switch(data.status){
                    case 1://success
                    $("#response").addClass("alert-success");
                    cname="alert-success";
                    $("#status").html("Welcome to the Family");
                    $("#user_name").val("");
                    $("#password").val("");
                    $("#re_password").val("");
                    $("#admin_key").val("");
                    //window.location.href=baseURL;
                    break;
                    case 2://Error
                    $("#response").addClass("alert-warning");
                    cname="alert-warning";
                    $("#status").html("Error");
                    break;
                    case 3://Fatal Error
                    $("#response").addClass("alert-danger");
                    cname="alert-danger";
                    $("#status").html("Fatal Error");
                    break;
                  }
                  $("#message").html(data.message);
                })
                .fail(function() {
                  $("#response").addClass("alert-danger");
                  cname="alert-danger";
                  $("#status").html("Fatal Error:");
                  $("#message").html("Please check Connection");
                })
                .always(function() {
                  $("#response").slideDown('fast');
                  $("html").css("cursor", "default");
                });
          });

          $(".form-group").click(function(){
            $("#response").slideUp('fast');
          });

        });
      </script>
    </div>
  </body>
</html>
