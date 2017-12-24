<template>
    <div id="edit_profile_app" class="edit_user">

        <div class="information_content">

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


                <button class="save">
                    Save
                </button>

            </form>

        </div>

    </div>
</template>

<style scoped>
</style>

<script>
    export default {
        data() {
            return {
                avatar: null,
                cover: null,
                userName: '',
                userStatus: ''
            }
        },
        mounted() {
            console.log('Update profile ok!')
        },
        methods: {

            // ---------------------------------------------------

            onFileChange(e, type) {

                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)return;

                let reader = new FileReader();

                reader.onload = (e) => {

                    if (type == 'avatar') this.avatar = e.target.result;
                    if (type == 'cover') this.cover = e.target.result;

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

            }

            // ---------------------------------------------------

        }
    }
</script>
