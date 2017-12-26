<template>
    <div id="add_group_app">

        <notifications :vue_notifications="notifications"></notifications>

        <router-link to="/groups/my">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <avatar v-if="access" :username="groupName" color="#fff" :src="avatar"></avatar>

        <h4 v-if="access"> Add new group </h4>
        <h4 v-else>To be able to add a group you must have friends...</h4>

        <hr>

        <form v-if="access"  v-on:submit.prevent="" method="POST" enctype="multipart/form-data">

            <div class="input wrap-input">

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

            </div>

            <select
                    name="listUsers"
                    v-model="selectedUsers"
                    multiple>
                <option v-for="user in  listUsers" :value="user.id">{{ user.name }}</option>
            </select>

        </form>

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
              listUsers: null,
              access: false,
              selectedUsers: []
          }
        },

        // ---------------------------------------------------

        mounted() {
            this.listFriends();
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

            listFriends() {

                this.loading = true;

                this.$http.get('/list_friends').then(response => {

                    this.loading = false;

                    if (response.status == 200) {

                        if (response.data.length != 0) {
                            this.listUsers = response.data;
                            this.access = true;
                        } else {
                            this.error('friends');
                            this.access = false;
                        }

                    } else {
                        this.error('friends');
                        this.access = false;
                    }

                }, () => {
                    this.loading = false;
                    this.access = false;
                    this.error('friends');
                });
            },

            // ---------------------------------------------------

            pushSelected(user) {
                this.selectedUsers.push(user);
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

            error(type = null) {
                if (type == 'friends') {
                    this.showNotification('Look for new friends firstly', 'error');
                } else {
                    this.showNotification('Group can not be added, try it later', 'error');
                }
            },

            // ---------------------------------------------------

            validation(msg) {
                if (msg.avatar) msg = msg.avatar[0];
                if (msg.name) msg = msg.name[0];

                this.showNotification(msg, 'validation');
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
                formData.append('users', this.groupName);
                if (this.avatar) formData.append('avatar', this.$refs.fileInput.files[0]);

                return formData;
            }

            // ---------------------------------------------------
        }
    }
</script>
