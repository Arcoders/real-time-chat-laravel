<template>
    <div class="friends">

        <div v-if="!loading">
            <div class="add_friend style_friend">

                <button v-if="status == 0" @click="add_friend">
                    <i class="material-icons">person_add</i>
                </button>

                <button v-if="status == 'pending'" @click="accept_friend">
                    <i class="material-icons">done_all</i>
                </button>

                <button v-if="status == 'waiting'">
                    <i class="material-icons">near_me</i>
                </button>

                <button v-if="status == 'friends'">
                    <i class="material-icons">favorite</i>
                </button>

            </div>

            <div v-if="status == 'pending'" class="delete_friend style_friend">
                <button @click="reject_friendship">
                    <i class="material-icons">clear</i>
                </button>
            </div>
        </div>

        <loading v-if="loading"></loading>

    </div>
</template>

<script>
    export default {

        // ---------------------------------------------------

        props: ['my_id', 'profile_user_id'],

        // ---------------------------------------------------

        watch: {
            profile_user_id() {
                this.relationShipStatus();
            }
        },

        // ---------------------------------------------------

        data() {
            return {
                status: '',
                loading: true,
                changeStatus: []
            }
        },

        // ---------------------------------------------------

        mounted() {
            this.relationShipStatus();
            this.updtateStatus();
        },

        // ---------------------------------------------------

        methods: {

            // ---------------------------------------------------

            updtateStatus() {
                this.channel = this.$pusher.subscribe('user' + this.my_id);
                this.channel.bind('updateStatus', () => {
                    this.relationShipStatus();
                });
            },

            // ---------------------------------------------------

            relationShipStatus() {
                this.$http.get('/check_relationship_status/'+this.profile_user_id).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
                        this.status = response.body.status;
                    } else {
                        // ...
                    }

                }, response => {
                    // ...
                });
            },

            // ---------------------------------------------------

            add_friend() {
                this.loading = true;

                this.$http.post('/add_friend/'+this.profile_user_id).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
                        if (response.body == 1) this.status = 'waiting';
                        if (response.body == 0) this.status = 0;
                    } else {
                        // ...
                    }

                }, response => {
                    // ...
                });
            },

            // ---------------------------------------------------

            accept_friend() {
                this.loading = true;

                this.$http.patch('/accept_friend/'+this.profile_user_id).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
                        if (response.body == 1) this.status = 'friends';
                        if (response.body == 0) this.status = 'pending';
                    } else {
                        // ...
                    }

                }, response => {
                    // ...
                });
            },

            // ---------------------------------------------------

            reject_friendship() {
                this.loading = true;

                this.$http.put('/reject_friendship/'+this.profile_user_id).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
                        if (response.body == 3) this.status = 0;
                    } else {
                        // ...
                    }

                }, response => {
                    // ...
                });
            }

            // ---------------------------------------------------

        }
    }
</script>