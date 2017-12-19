<template>
    <div id="messages_app">

        <div class="chat-bubble me">
            <div class="my-mouth">
                <img class="me_img" src="https://avatars.io/twitter/maryam">
            </div>
            <div class="content">قولي أحبك كي تزيد وسامتي فبغير حبك ما أكون جميلا</div>
            <div class="time">15:20</div>
        </div>

        <div class="chat-bubble you">
            <div class="your-mouth">
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
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
                <avatar :username="user.name"
                        color="#fff"
                        :src="user.avatar"
                        class="you_img">
                </avatar>
            </div>
            <div class="content">Awdi ghir m3a dnya</div>
            <div class="time">15:27</div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['user'],
        mounted() {
            console.log('Messages ok!');
        }
    }
</script>
