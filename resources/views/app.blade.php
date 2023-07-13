<!DOCTYPE html>
<html lang="{{ config('app.locale', 'en') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Repair Box') }}</title>
    <link rel="shortcut icon" href="{{ $fav_icon }}">
    <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
    <link href="{{asset('/css/custom-style.css')}}" rel="stylesheet">

    @if($app_data['square_state'])
    @if($app_data['square_sandbox'])
    <script src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
    @else
    <script src="https://web.squarecdn.com/v1/square.js"></script>
    @endif
    @endif
</head>
<body>
    @if(config('app.demo_mode'))
    <div class="bg-yellow-200 border border-yellow-400 text-black text-sm px-5 md:flex justify-between">
      <span><a href="https://pronic.co.ke/" target="_blank" rel="noopener">Click for documentation</a></span>
      <span>Please fill valid/active email to get notification.</span>
      <span>Bug report at <a href="mailto:info.pronic.co.ke" rel="noopener" target="_blank">info.pronic.co.ke</a></span>
      <span>v {{ config('app.version') }}</span>
  </div>
  @endif
  <div id="app"></div>
  <script>
    window.app = {!! json_encode( $app_data, JSON_THROW_ON_ERROR) !!};
</script>
@routes
<script src="{{ url(mix('js/app.js')) }}"></script>
</body>
</html>
