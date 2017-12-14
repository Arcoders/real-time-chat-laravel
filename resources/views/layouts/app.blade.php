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

                <div class="wrap-search">
                    <div class="search">
                        <i class="fa fa-search fa" aria-hidden="true"></i>
                        <input type="text" class="input-search" placeholder="Buscar contacto">
                    </div>
                </div>

                <div class="wrap-filter">
                    <div class="link_filter">
                        <a href="#">Groups</a>
                    </div>
                    <div class="link_filter">
                        <a href="#">Private</a>
                    </div>
                </div>

                <div class="contact-list">

                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>
                    <div class="contact">
                        <img src="https://avatars.io/twitter/maryam" alt="profilpicture">
                        <div class="contact-preview">
                            <div class="contact-text">
                                <h1 class="font-name">Nuevo amigo</h1>
                                <p class="font-preview">Hola muy buenas.</p>
                            </div>
                        </div>
                        <div class="contact-time">
                            <p>00:24</p>
                        </div>
                    </div>

                </div>
            </section>

            <section class="right">


                <div class="chat-head">
                    <img alt="profilepicture" src="https://avatars.io/twitter/maryam">
                    <div class="chat-name">
                        <h1 class="font-name">Laravel</h1>
                        <p class="font-online">Ismael, Fatima, Admin, Marta, victor...</p>
                    </div>
                    <i class="fa fa-whatsapp fa-lg" aria-hidden="true"></i>
                </div>


                <div class="wrap-chat">

                    <div class="chat">

                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>

                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>


                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>

                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>

                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>


                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>

                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>

                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>

                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>

                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>

                        <div class="chat-bubble me">
                            <div class="my-mouth">
                                <img class="me_img" src="https://avatars.io/twitter/maryam">
                            </div>
                            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
                            <div class="time">15:20</div>
                        </div>

                        <div class="chat-bubble you">
                            <div class="your-mouth">
                                <img class="you_img" src="https://avatars.io/twitter/nada">
                            </div>
                            <div class="content">Awdi ghir m3a dnya</div>
                            <div class="time">15:27</div>
                        </div>

                    </div>

                    <div class="upload_foto">
                        <div class="container_foto font-preview">
                            <p>Subir imagen</p>
                        </div>
                    </div>

                </div>



                <div class="wrap-message">
                    <i class="fa fa-smile-o fa-lg" aria-hidden="true"></i>
                    <div class="message">
                        <input type="text" class="input-message" placeholder="Escribe un nuevo mensaje">
                    </div>
                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                </div>


            </section>
        </div>


        <!-- End chat app -->

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
