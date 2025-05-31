<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">    
    <title>
      Privacy Policy
    </title>
  </head>
  <style>
    @media only screen and (max-width: 600px) { .logoimg{ width: 320px !important;
    margin-top: 0px !important; margin-left: 0% !important; } }
  </style>
  
  <body style="background: #0e0d0d;">
    <div class="container mb-5 mt-3" style="color: white;">
      
       <img width="120" src="https://meraprachaar.shop/uploads/logo.png"
      alt="logo" class="logoimg" style="margin-left: 491px; width: 101px;">
      
      <h1 class="mb-5 mt-3">Privacy Policy for Mera Prachaar<h2>
      
      					@php
                            $iterator = 1;
                        @endphp
                        @foreach ($privacy->privacy_policy as $privacy)
      
      					<h3 style="margin-top: 20px;">
                          {{$privacy->title}}
                        </h3>
      	
      					<p>
                          {{$privacy->paragraph}}
                        </p>
                        @php
                            $iterator += 1;
                        @endphp                       
                        @endforeach  
                    </div>
      
      
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
  crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
  integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
  crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
  crossorigin="anonymous">
  </script>

</html>