<template>
    <div id="add_group_app">

        <notifications :vue_notifications="notifications"></notifications>

        <router-link to="/groups/my">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <avatar :username="groupName" color="#fff" :src="avatar"></avatar>

        <h4> Add new group </h4>

        <hr>

        <div class="wrap-input">

                <form class="input" v-on:submit.prevent="" method="POST" enctype="multipart/form-data">

                    <label class="fileContainer font-online">

                        <button v-if="!avatar" type="button">
                            <i class="material-icons">photo</i>
                        </button>

                        <button v-else v-on:click="avatar = null" type="button">
                            <i class="material-icons">clear</i>
                        </button>

                        <input v-show="!avatar"
                               type="file"
                               name="avatar"
                               v-on:change="onFileChange($event)"
                               ref="fileInput">

                    </label>

                    <input @keyup.enter="addGroup"
                           v-model="groupName"
                           name="name"
                           type="text"
                           class="input-global"
                           placeholder="Group name...">

                    <button type="button" @click="addGroup" v-bind:disabled="btnSubmit">
                        <i class="material-icons">add</i>
                    </button>

                </form>
        </div>

        <loading v-if="loading"></loading>

    </div>
</template>

<style scoped>
    a {
        text-decoration: none;
        color: #777777;
    }
    .fileContainer i{
        font-size: 23px;
        color: #777777;
    }
</style>

<script>
    export default {

        // ---------------------------------------------------

        data() {
          return {
              groupName: '',
              avatar: null,
              loading: false,
              notifications: [],
              time: 4000
          }
        },

        // ---------------------------------------------------

        mounted() {
            console.log('Add group ok!');
        },

        // ---------------------------------------------------

        methods: {

            // ---------------------------------------------------

            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                let reader = new FileReader();

                if (!files.length) return;

                reader.onload = e => this.avatar = e.target.result;
                reader.readAsDataURL(files[0]);
            },

            // ---------------------------------------------------

            resetForm() {
                this.avatar = null;
                this.groupName = '';
            },

            // ---------------------------------------------------

            addGroup() {

                if (this.btnSubmit) return;
                this.loading = true;

                this.$http.post('/new_group', this.formData).then(response => {

                    this.loading = false;

                    (response.status == 200) ? this.done(response.data) : this.error();

                }, response => {

                    this.loading = false;

                    (response.status == 422) ? this.validation(response.data.errors) : this.error();

                });
            },

            // ---------------------------------------------------

            error() {
                this.showNotification('Group can not be added, try it later', 'error');
            },

            // ---------------------------------------------------

            validation(msg) {
                this.showNotification(msg.name[0] || msg.avatar[0], 'validation');
            },

            // ---------------------------------------------------

            done(msg) {
                this.showNotification(msg, 'done');
                this.resetForm();
            },

            // ---------------------------------------------------

            showNotification(msg, type) {
                this.notifications.push({ message: msg, type: type });
                setTimeout(() => {
                    this.notifications.shift();
                }, this.time);
            },

            // ---------------------------------------------------

        },

        // ---------------------------------------------------

        computed: {

            // ---------------------------------------------------

            btnSubmit() {
                return ( this.groupName.length < 3);
            },

            // ---------------------------------------------------

            formData() {
                let formData = new FormData();

                formData.append('name', this.groupName);
                if (this.avatar) formData.append('avatar', this.$refs.fileInput.files[0]);

                return formData;
            }

            // ---------------------------------------------------
        }
    }
</script>
