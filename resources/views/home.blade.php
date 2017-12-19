@extends('layouts.chat')

@section('aplication')
    <div class="green-background"></div>

    <div class="wrap">


        <section class="left">

            <left :user="{{ Auth::user() }}"></left>

        </section>


        <section class="right">


            <router-view :user="{{ Auth::user() }}" :key="$route.fullPath"></router-view>


        </section>

    </div>
@endsection
