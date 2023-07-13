@extends('frontend.layout.front')
@section('content')
  <div class="justify-center container mx-auto p-10">
    <strong class="text-3xl">{{ $page->title }}</strong>
    <p class="py-10" >{!! html_entity_decode($page->content) !!}</p>
  </div>
@endsection
