<template>
    <div id="edit_group_app" v-if="showEdit">

        <notifications :vue_notifications="notifications"></notifications>

        <router-link to="/groups/my">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <avatar :username="groupName" color="#fff" :src="avatar"></avatar>

        <h4> Edit group </h4>

        <hr>

        <div class="wrap-input">

                <form class="input" id="f" v-on:submit.prevent="" method="POST" enctype="multipart/form-data">

                    <label class="fileContainer font-online">

                        <button v-if="!avatar" type="button">
                            <i class="material-icons">photo</i>
                        </button>

                        <button v-else v-on:click="clearAvatar" type="button">
                            <i class="material-icons">clear</i>
                        </button>

                        <input v-show="!avatar"
                               type="file"
                               name="avatar"
                               v-on:change="onFileChange($event)"
                               ref="fileInput">

                    </label>

                    <input @keyup.enter="editGroup"
                           v-model="groupName"
                           name="name"
                           type="text"
                           class="input-global"
                           placeholder="Group name...">

                    <button type="button" @click="editGroup" v-bind:disabled="btnSubmit">
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
              time: 4000,
              group_id: this.$route.params.group_id,
              showEdit: false,
              newImage: false
          }
        },

        // ---------------------------------------------------

        mounted() {
            this.getGroup();
            console.log('Edit group ok!');
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
                this.newImage = true;
            },

            // ---------------------------------------------------

            clearAvatar() {
                this.avatar = null;
                this.editGroup('image');
            },

            // ---------------------------------------------------

            editGroup(type = null) {

                if (this.btnSubmit) return;
                this.loading = true;

                let data;

                if (type == 'image') {
                    data = {deleteImage: true, name: this.groupName}
                } else {
                    data = this.formData;
                }

                this.$http.post('/edit_group/' + this.group_id, data).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
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
                this.showNotification('Group can not be edited, try it later', 'error');
            },

            // ---------------------------------------------------

            validation(msg) {
                this.showNotification(msg.name[0] || msg.avatar[0], 'validation');
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
                }, this.time);
            },

            // ---------------------------------------------------

            getGroup() {
                this.$http.get('/get_group/' + this.group_id).then(response => {

                    if (response.status == 200) {

                        if (response.data == 0) return this.$router.push('/groups/my');

                        this.showEdit = true;

                        this.groupName = response.data.name;
                        if (response.data.avatar) this.avatar = '/images/avatars/' + response.data.avatar;

                    } else {
                        this.$router.push('/groups/my');
                    }

                }, () => {
                    this.$router.push('/groups/my');
                });
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
                if (this.newImage) formData.append('avatar', this.$refs.fileInput.files[0]);

                return formData;
            }

            // ---------------------------------------------------
        }
    }
</script>
