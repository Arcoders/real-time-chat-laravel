<template lang="pug">
    #edit_group_app(v-if='showEdit')
        notifications(:vue_notifications='notifications')
        router-link(to='/groups/my')
            i.material-icons arrow_back
        avatar(:username='groupName', color='#fff', :src='avatar')
        h4  Edit group
        hr
        form(v-on:submit.prevent='', method='POST', enctype='multipart/form-data')
            .input.wrap-input
                label.fileContainer.font-online
                    button(v-if='!avatar', type='button')
                        i.material-icons photo
                    button(v-else='', v-on:click='clearAvatar', type='button')
                        i.material-icons clear
                    input(v-show='!avatar', type='file', name='avatar', v-on:change='onFileChange($event)', ref='fileInput')
                input.input-global(@keyup.enter='editGroup', v-model='groupName', name='name', type='text', placeholder='Group name...')
                button(type='button', @click='editGroup', v-bind:disabled='btnSubmit')
                    i.material-icons add
            br
            .input.wrap-input
                multiselect(v-model='selectedUsers', :multiple='true', track-by='id', label='name', :hide-selected='true', :close-on-select='false', :options='listUsers')
                    template(slot='tag', slot-scope='props')
                        span.custom__tag
                            span  {{ props.option.name }}
                            span.custom__remove(@click='props.remove(props.option)')  ❌
        loading(v-if='loading')

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
