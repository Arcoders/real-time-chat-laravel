<template lang="pug">
    .friends
        div(v-if='!loading')
            .add_friend.style_friend
                button(v-if="status == 'add'", @click='add_friend')
                    i.material-icons person_add
                button(v-if="status == 'pending'", @click='accept_friend')
                    i.material-icons done_all
                button(v-if="status == 'waiting'")
                    i.material-icons near_me
                button(v-if="status == 'friends'")
                    i.material-icons favorite
            .delete_friend.style_friend(v-if="status == 'pending'")
                button(@click='reject_friendship')
                    i.material-icons clear
        loading(v-if='loading')
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
                        if (response.body == 'waiting') this.status = 'waiting';
                        if (response.body == 'add') this.status = 'add';
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
                        if (response.body == 'friends') this.status = 'friends';
                        if (response.body == 'pending') this.status = 'pending';
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

                this.$http.delete('/reject_friendship/'+this.profile_user_id).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
                        if (response.body == 'deleted') this.status = 'add';
                        if (response.body == 'pending') this.status = 'pending';
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