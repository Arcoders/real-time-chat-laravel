@extends('layouts.chat')

@section('aplication')
    <div class="green-background"></div>

    <div class="wrap">


        <section class="left">

            <left :auth_user="{{ Auth::user() }}"></left>

        </section>


        <section class="right">


            <router-view :key="$route.fullPath"></router-view>


        </section>

    </div>
@endsection
