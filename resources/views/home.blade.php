@extends('layouts.chat')

@section('aplication')

    <div class="green-background"></div>

    <global :auth_user="{{ Auth::user() }}"></global>

@endsection
