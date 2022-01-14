<!DOCTYPE html>
<html lang="en">
  
<head>
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
        /* background-color:#f7f7f7; */
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
    <div class="card bd-0 card-floating rounded-10" style="width: 400px;display: none;" id="cs-chat-box">
      <div class="card-header tx-medium bd-0 d-flex justify-content-between" style="border-top-left-radius: 10px;border-top-right-radius: 10px;">
        <div class="d-flex align-items-center">
          <img src="{{ 'data:image/jpeg;base64,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' }}" 
            class="rounded-circle mg-r-10" alt="" style="width: 30px; height: 30px;">
          <span class="mg-r-10" id="chat-user-name">Bot</span>
          <span><button class="btn btn-indigo btn-with-icon rounded-pill" type="button" id="btn-connect-cs"><i class="typcn typcn-flow-switch"></i> Sambungkan ke Cs</button></span>
        </div>
        <span class="close" id="cs-chat-btn-close" style="cursor: pointer;">&times;</span>
      </div><!-- card-header -->
      <div class="card-body bd bd-t-0 px-0 position-relative" 
      style="min-height: 400px;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;"
      >
        <div class="px-2" style="max-height: 330px!important;overflow-y: auto!important;" id="chat-body"></div>
        <div class="form-chat d-flex position-absolute w-100 bd-t bd-gray-200" style="bottom: 0;left: 0;">
          <input type="text" name="input_chat" id="" class="form-control flex-grow-1" 
            style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;border-left: 0;border-right: 0;border-bottom: 0;">
        </div>
      </div><!-- card-body -->
    </div><!-- card -->
    <button class="btn btn-indigo btn-with-icon btn-rounded btn-floating" id="cs-chat-btn">
      <i class="tx-16 typcn typcn-headphones"></i> Bantuan
      <!-- <img src="https://www.clipartmax.com/png/middle/258-2587133_superior-customer-service-phone-service-icon.png" alt="" srcset="" width="40px" height="40px"> -->
    </button>
  </body>

  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  @yield('js_body')
  @include('layouts.apps.script-chat')
</html>
