<template>
    <div id="edit_profile_app">

        <div class="information_content">
            <h1>Edit information:</h1>

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
                <input type="file"/>
            </label>

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
        mounted() {
            console.log('Update profile ok!')
        }
    }
</script>
