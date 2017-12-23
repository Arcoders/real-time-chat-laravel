<template>
    <div id="edit_profile_app" class="edit_user">

        <div class="information_content">

            <form method="POST" v-on:submit.prevent="upload()" class="information_form" enctype="multipart/form-data">

                <h1>Edit information</h1>

                <div class="edit-input">
                    <input type="text" placeholder="User name">
                </div>

                <div class="edit-input">
                    <input type="text"  placeholder="Status">
                </div>

                <h1>Select avatar</h1>


                <label class="fileContainer">
                    <button>
                        <i class="material-icons edit_i">photo_camera</i>
                        <span class="select_image">Change avatar</span>
                    </button>
                    <input type="file" name="fileInput" v-on:change="onFileChange($event)" ref="fileInput">
                </label>

                <h1>Select Cover</h1>

                <label class="fileContainer">
                    <button>
                        <i class="material-icons edit_i">photo_size_select_actual</i>
                        <span class="select_image">Choose Cover</span>
                    </button>
                    <input type="file" name="fileInput" v-on:change="onFileChange($event)" ref="fileInput">
                </label>

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
                avatar: null
            }
        },
        mounted() {
            console.log('Update profile ok!')
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.avatar = e.target.result;
                    this.$emit('previewImage', this.avatar);
                };
                reader.readAsDataURL(file);
            }
        }
    }
</script>
