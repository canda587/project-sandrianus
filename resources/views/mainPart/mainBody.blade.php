@extends('mainPart.mainPart')

@section('mainBody')

{{-- navigate --}}
@include('part.navigate')


{{-- main content --}}
@yield('mainContent')



{{-- footer --}}
@include('part.footer')

@endsection