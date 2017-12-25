<template>
    <div id="edit_profile_app" class="edit_user">

        <div class="information_content">

            <notifications :vue_notifications="notifications" :width="100"></notifications>

            <form method="POST" v-on:submit.prevent="updateProfile()" class="information_form" enctype="multipart/form-data">

                <h1>Edit information</h1>

                <div class="edit-input">
                    <input type="text"
                           v-on:keyup="onInputChange($event, 'name')"
                           v-model="userName"
                           placeholder="User name">
                </div>

                <div class="edit-input">
                    <input type="text"
                           v-on:keyup="onInputChange($event, 'status')"
                           v-model="userStatus"
                           placeholder="Status">
                </div>

                <h1>Select avatar</h1>


                <label class="fileContainer">
                    <button>
                        <i class="material-icons edit_i">photo_camera</i>
                        <span class="select_image">Change avatar</span>
                    </button>
                    <input type="file" name="fileInput" v-on:change="onFileChange($event, 'avatar')" ref="fileInput">
                </label>

                <h1>Select Cover</h1>

                <label class="fileContainer">
                    <button>
                        <i class="material-icons edit_i">photo_size_select_actual</i>
                        <span class="select_image">Choose Cover</span>
                    </button>
                    <input type="file" name="fileCover" v-on:change="onFileChange($event, 'cover')" ref="fileCover">
                </label>


                <button class="save" v-if="btnSubmit">
                    Save
                </button>

            </form>

            <loading v-if="loading" :normal="true"></loading>

        </div>

    </div>
</template>

<style scoped>
</style>

<script>
    export default {
        // ---------------------------------------------------

        props: ['user'],

        // ---------------------------------------------------

        data() {
            return {
                avatar: this.user.avatar,
                cover: this.user.cover,
                userName: this.user.name,
                userStatus: this.user.status,
                newAvatar: false,
                newCover: false,
                notifications: [],
                loading: false,
                time: 4000
            }
        },

        // ---------------------------------------------------

        mounted() {
            console.log('Update profile ok!')
        },

        // ---------------------------------------------------

        methods: {

            // ---------------------------------------------------

            onFileChange(e, type) {

                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)return;

                let reader = new FileReader();

                reader.onload = (e) => {

                    if (type == 'avatar')
                    {
                        this.avatar = e.target.result;
                        this.newAvatar = true;
                    }


                    if (type == 'cover')
                    {
                        this.cover = e.target.result;
                        this.newCover = true;
                    }

                    this.$emit('previewImage', {
                        'avatar': this.avatar,
                        'cover': this.cover
                    });


                };

                reader.readAsDataURL(files[0]);
            },

            // ---------------------------------------------------

            onInputChange() {
                this.$emit('modelInfo', {
                    'user': this.userName,
                    'status': this.userStatus
                });
            },

            // ---------------------------------------------------

            updateProfile() {

                if (!this.btnSubmit) return;
                this.loading = true;

                this.$http.post('/edit_profile', this.formData).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
                        this.done(response.data);
                    } else {
                         this.error();
                    }

                }, response => {

                    this.loading = false;
                    this.test = response.data;

                    if (response.status == 422) {
                        this.validation(response.data.errors);
                    } else {
                        this.error();
                    }

                });
            },

            // ---------------------------------------------------

            error() {
                this.showNotification('Group can not be edited, try it later', 'error');
            },

            // ---------------------------------------------------

            validation(msg) {
                if (msg.avatar) msg = msg.avatar[0];
                if (msg.cover) msg = msg.cover[0];
                if (msg.name) msg = msg.name[0];

                this.showNotification(msg, 'validation');
            },

            // ---------------------------------------------------

            done(msg) {
                this.showNotification(msg, 'done');
            },

            // ---------------------------------------------------

            showNotification(msg, type) {
                this.notifications.push({ message: msg, type: type });

                setTimeout(() => {
                    this.notifications.shift();
                    if (type == 'done') this.$router.go(this.$router.currentRoute);
                }, this.time);

                this.newAvatar = false;
                this.newCover = false;
            },

            // ---------------------------------------------------

        },
        computed: {

            // ---------------------------------------------------

            btnSubmit() {
                return ( this.userName.length >= 3 && this.userStatus.length >= 3);
            },

            // ---------------------------------------------------

            formData() {
                let formData = new FormData();

                formData.append('name', this.userName);
                formData.append('status', this.userStatus);
                if (this.newAvatar) formData.append('avatar', this.$refs.fileInput.files[0]);
                if (this.newCover) formData.append('cover', this.$refs.fileCover.files[0]);

                return formData;
            },

            // ---------------------------------------------------

        }
    }
</script>
