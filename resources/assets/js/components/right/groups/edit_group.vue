<template>
    <div id="edit_group_app" v-if="showEdit">

        <notifications :vue_notifications="notifications"></notifications>

        <router-link to="/groups/my">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <avatar :username="groupName" color="#fff" :src="avatar"></avatar>

        <h4> Edit group </h4>

        <hr>

        <form v-on:submit.prevent="" method="POST" enctype="multipart/form-data">

                <div class="input wrap-input">

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

                </div>

            <br>

            <div class="input wrap-input">
                <multiselect v-model="selectedUsers"
                             :multiple="true"
                             track-by="id"
                             label="name"
                             :hide-selected="true"
                             :close-on-select="false"
                             :options="listUsers">

                    <template slot="tag" slot-scope="props">
                        <span class="custom__tag">
                            <span> {{ props.option.name }} </span>
                            <span class="custom__remove" @click="props.remove(props.option)"> ❌ </span>
                        </span>
                    </template>

                </multiselect>
            </div>

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
              group_id: this.$route.params.group_id,
              showEdit: false,
              newImage: false,
              listUsers: null,
              selectedUsers: [],
              selectedIds: []
          }
        },

        // ---------------------------------------------------

        mounted() {
            this.listFriends();
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
                if (msg.avatar) msg = msg.avatar[0];
                if (msg.name) msg = msg.name[0];
                if (msg.id) msg = msg.id[0];

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
                }, this.time);
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
                            this.$router.push('/groups/my');
                        }

                    } else {
                        this.$router.push('/groups/my');
                    }

                }, () => {
                    this.loading = false;
                    this.$router.push('/groups/my');
                });
            },

            // ---------------------------------------------------

            getGroup() {
                this.$http.get('/get_group/' + this.group_id).then(response => {

                    if (response.status == 200) {

                        if (response.data == 0) return this.$router.push('/groups/my');

                        this.showEdit = true;

                        this.groupName = response.data.name;
                        if (response.data.avatar) this.avatar = response.data.avatar;
                        this.selectedUsers = response.data.users;

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

                this.selectedIds = Object.keys(this.selectedUsers).map(
                    s => this.selectedUsers[s].id
                );

                formData.append('id', this.selectedIds);

                return formData;
            }

            // ---------------------------------------------------
        }
    }
</script>
