<template>
    <div id="edit_profile_app">

        <div class="information_content">
            <h1>Edit information:</h1>

            <form method="POST" v-on:submit.prevent="upload()" enctype="multipart/form-data">

                <div class="wrap-input">
                    <input type="text" class="input-global" placeholder="User name">
                </div>

                <div class="wrap-input add_padding">
                    <input type="text" class="input-global" placeholder="Status">
                </div>

                <br>

                <h1>Edit avatar:</h1>

                <label class="fileContainer font-online">
                    <button>
                        Click here to trigger the file uploader!
                    </button>
                    <input type="file" name="fileInput" v-on:change="onFileChange($event)" ref="fileInput">
                </label>

            </form>

        </div>

    </div>
</template>

<style scoped>
    .green_teal {
        color: #009688;
    }
    .wrap-input {
        padding: 2px 2px 0 2px;
    }
    .add_padding {
        padding-bottom: 2px;
    }
    button {
        color: #444444;
    }
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
