<template lang="pug">

    #edit_profile_app.edit_user
        .information_content
            notifications(:vue_notifications='notifications', :width='100')
            form.information_form(method='POST', v-on:submit.prevent='updateProfile()', enctype='multipart/form-data')
                h1 Edit information
                .edit-input
                    input(type='text', v-on:keyup="onInputChange($event, 'name')", v-model='userInfo.name', placeholder='User name')
                .edit-input
                    input(type='text', v-on:keyup="onInputChange($event, 'status')", v-model='userInfo.status', placeholder='Status')
                h1 Select avatar
                label.fileContainer
                    button
                        i.material-icons.edit_i photo_camera
                        span.select_image Change avatar
                    input(type='file', name='fileInput', v-on:change="onFileChange($event, 'avatar')", ref='fileInput')
                h1 Select Cover
                label.fileContainer
                    button
                        i.material-icons.edit_i photo_size_select_actual
                        span.select_image Choose Cover
                    input(type='file', name='fileCover', v-on:change="onFileChange($event, 'cover')", ref='fileCover')
                button.save(v-if='btnSubmit')
                    | Save
            loading(v-if='loading')

</template>

<style scoped>
</style>

<script>
    export default {

        // ---------------------------------------------------

        props: ['userInfo'],

        // ---------------------------------------------------

        data() {
            return {
                user: this.$store.state.user,
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
                    'user': this.userInfo.name,
                    'status': this.userInfo.status
                });
            },

            // ---------------------------------------------------

            updateProfile() {

                if (!this.btnSubmit) return;
                this.loading = true;

                this.$http.post('/edit_profile', this.formData).then(response => {

                    this.loading = false;

                    if (response.status === 200) {
                        this.done(response.data);
                    } else {
                         this.error();
                    }

                }, response => {

                    this.loading = false;

                    if (response.status == 422) {
                        this.validation(response.data.errors);
                    } else {
                        this.error();
                    }

                });
            },

            // ---------------------------------------------------

            error() {
                this.showNotification('User can not be edited, try it later', 'error');
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
                this.showNotification(msg.info, 'done');
                this.$store.commit('updateUser', msg.user);
            },

            // ---------------------------------------------------

            showNotification(msg, type) {
                this.notifications.push({ message: msg, type: type });

                setTimeout(() => {
                    this.notifications.shift();
                }, this.time);

                this.newAvatar = false;
                this.newCover = false;
            },

            // ---------------------------------------------------

        },
        computed: {

            // ---------------------------------------------------

            btnSubmit() {
                return ( this.userInfo.name.length >= 3 && this.userInfo.status.length >= 3);
            },

            // ---------------------------------------------------

            formData() {
                let formData = new FormData();

                formData.append('name', this.userInfo.name);
                formData.append('status', this.userInfo.status);
                if (this.newAvatar) formData.append('avatar', this.$refs.fileInput.files[0]);
                if (this.newCover) formData.append('cover', this.$refs.fileCover.files[0]);

                return formData;
            },

            // ---------------------------------------------------

        }
    }
</script>
