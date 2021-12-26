<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from www.bootstrapdash.com/demo/azia/v1.0.0/template/dashboard-one.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 27 Nov 2021 17:05:49 GMT -->
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-90680653-2');
    </script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ env('APP_NAME') }}</title>

    @yield('css_head')

    <style>
      body{
        background-color:#f7f7f7;
        max-width: 100vw!important;
        overflow-x: hidden;
      }
      .bg-image-center {
        background-position: center;
        background-repeat: no-repeat;
        background-size: 100% 100%;
      }
      .btn-floating{
        position: fixed;
        right: 20px;
        bottom: 20px;
      }
      .card-floating{
        position: fixed;
        right: 20px;
        bottom: 20px;
      }
    </style>

  </head>
  <body>

    @include('layouts.apps.navbar')

    @yield('content-body')

    @include('layouts.apps.footer')
    <div class="card bd-0 card-floating rounded-10" style="width: 300px;display: none;" id="cs-chat-box">
      <div class="card-header tx-medium bd-0 tx-white bg-indigo d-flex justify-content-between" style="border-top-left-radius: 10px;border-top-right-radius: 10px;">
        <span>Live Chat</span>
        <span class="close" id="cs-chat-btn-close" style="cursor: pointer;">&times;</span>
      </div><!-- card-header -->
      <div class="card-body bd bd-t-0 position-relative" 
      style="min-height: 400px;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
        <p class="mg-b-0"></p>
        <div class="form-chat d-flex position-absolute w-100" style="bottom: 0;left: 0;">
          <input type="text" name="input_chat" id="" class="form-control flex-grow-1" 
            style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-left: 0;border-right: 0;border-bottom: 0;">
        </div>
      </div><!-- card-body -->
    </div><!-- card -->
    <button class="btn btn-indigo btn-with-icon btn-rounded btn-floating" id="cs-chat-btn">
      <i class="tx-16 typcn typcn-headphones"></i> Customer Service Chat
      <!-- <img src="https://www.clipartmax.com/png/middle/258-2587133_superior-customer-service-phone-service-icon.png" alt="" srcset="" width="40px" height="40px"> -->
    </button>
  </body>

  @yield('js_body')
  <script>
    var live_chat_active = false;
    var box_cs_chat = document.getElementById('cs-chat-box');
    var btn_cs_chat = document.getElementById('cs-chat-btn');
    var btn_cs_chat_close = document.getElementById('cs-chat-btn-close');
    var input_chat = document.querySelector('input[name=input_chat]');
    
    box_cs_chat.style.bottom += 20 + btn_cs_chat.offsetHeight + 10 + 'px';
    box_cs_chat.style.display = 'none';
    function toogleCsChat() {
      live_chat_active = !live_chat_active;
      if(live_chat_active) {
        box_cs_chat.style.display = 'block';
        input_chat.focus();
      } else {
        box_cs_chat.style.display = 'none';
      }
    }
    btn_cs_chat_close.addEventListener('click', function() {
      if(live_chat_active) {
        toogleCsChat();
      }
    });
    btn_cs_chat.addEventListener('click', function() {
      toogleCsChat();
    });
  </script>
</html>
