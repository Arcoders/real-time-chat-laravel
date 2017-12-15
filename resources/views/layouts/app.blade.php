<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <!-- Chat app -->



        <div class="green-background"></div>

            <div class="wrap">


                <section class="left">

                    <div class="profile">
                        <img src="https://avatars.io/twitter/nada">
                        <div class="icons">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <i class="fa fa-cog" aria-hidden="true"></i>
                            <i class="fa fa-bell" aria-hidden="true"></i>
                            <i class="fa fa-power-off" aria-hidden="true"></i>
                        </div>
                    </div>

                    <search></search>

                    <div class="wrap-filter">
                        <div class="link_filter">
                            <router-link to="/" exact-active-class="active">Private</router-link>
                        </div>
                        <div class="link_filter">
                            <router-link to="/groups" exact-active-class="active">Groups</router-link>
                        </div>
                    </div>

                    <div class="contact-list">
                        <router-view></router-view>
                    </div>

                </section>


                <section class="right">


                    <right></right>


                </section>

            </div>


        <!-- End chat app -->

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
