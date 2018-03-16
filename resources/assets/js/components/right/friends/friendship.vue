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
            .delete_friend.style_friend(v-if="status != 'add'")
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
            this.updateStatus();
        },

        // ---------------------------------------------------

        methods: {

            // ---------------------------------------------------

            updateStatus() {
                this.channel = this.$pusher.subscribe('user' + this.my_id);
                this.channel.bind('updateStatus', () => {
                    this.relationShipStatus();
                });
            },

            // ---------------------------------------------------

            relationShipStatus() {
                this.$http.get(`/friendship/check/${this.profile_user_id}`).then(response => {

                    this.loading = false;

                    if (response.status === 200) this.status = response.body.status;
                });
            },

            // ---------------------------------------------------

            add_friend() {
                this.loading = true;

                this.$http.post('/friendship/add/'+this.profile_user_id).then(response => {

                    this.loading = false;

                    if (response.status === 200) this.status = response.body;

                });
            },

            // ---------------------------------------------------

            accept_friend() {
                this.loading = true;

                this.$http.patch(`/friendship/accept/${this.profile_user_id}`).then(response => {

                    this.loading = false;

                    if (response.status === 200) this.status = response.body;

                });
            },

            // ---------------------------------------------------

            reject_friendship() {
                this.loading = true;

                this.$http.delete('/friendship/reject/'+this.profile_user_id).then(response => {

                    this.loading = false;

                    if (response.status === 200) this.status = response.body;

                });
            }

            // ---------------------------------------------------

        }
    }
</script>