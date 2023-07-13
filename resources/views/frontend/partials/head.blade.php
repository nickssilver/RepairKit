<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Repair Box') }}</title>
    <link rel="shortcut icon" href="{{ $fav_icon }}">
    <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">
</head>
