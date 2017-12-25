<template>
    <div class="friends">
        <p class="text-center" v-if="loading">
            Loading
        </p>

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
                <button>
                    <i class="material-icons">clear</i>
                </button>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        props: ['my_id', 'profile_user_id'],
        data() {
            return {
                status: '',
                loading: true,
                changeStatus: []
            }
        },
        mounted() {
            this.relationShipStatus();
            this.updtateStatus();
        },
        methods: {
            updtateStatus() {
                this.channel = this.$pusher.subscribe('user' + this.my_id);
                this.channel.bind('updateStatus', (data) => {
                    this.relationShipStatus();
                });
            },
            relationShipStatus() {
                this.$http.get('/check_relationship_status/'+this.profile_user_id).then(response => {
                    if (response.status == 200) {
                        this.status = response.body.status;
                        this.loading = false;
                    } else {
                        // ...
                    }
                }, response => {
                    // ...
                });
            },
            add_friend() {
                this.loading = true;
                this.$http.post('/add_friend/'+this.profile_user_id).then(response => {
                    if (response.status == 200) {
                        if (response.body == 1) this.status = 'waiting';
                        if (response.body == 0) this.status = 0;
                        this.loading = false;
                    } else {
                        // ...
                    }
                }, response => {
                    // ...
                });
            },
            accept_friend() {
                this.loading = true;
                this.$http.patch('/accept_friend/'+this.profile_user_id).then(response => {
                    if (response.status == 200) {
                        if (response.body == 1) this.status = 'friends';
                        if (response.body == 0) this.status = 'pending';
                        this.loading = false;
                    } else {
                        // ...
                    }
                }, response => {
                    // ...
                });
            }
        }
    }
</script>