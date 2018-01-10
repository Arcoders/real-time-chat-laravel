<template lang="pug">

    #add_group_app

        notifications(:vue_notifications='notifications')

        router-link(to='/groups/my')
            i.material-icons arrow_back

        avatar(v-if='access', :username='groupName', color='#fff', :src='avatar')

        h4(v-if='access')  Add new group
        h4(v-else) To be able to add a group you must have friends...

        hr

        form(v-if='access', v-on:submit.prevent='', method='POST', enctype='multipart/form-data')

            .input.wrap-input

                multiselect(v-model='selectedUsers',
                            :multiple='true',
                            track-by='id',
                            label='name',
                            :hide-selected='true',
                            :close-on-select='false',
                            :options='listUsers')

                    template(slot='tag', slot-scope='props')
                        span.custom__tag
                            span  {{ props.option.name }}
                            span.custom__remove(@click='props.remove(props.option)')  ❌

            br
            br

            .input.wrap-input

                label.fileContainer.font-online

                    button(v-if='!avatar', type='button')
                        i.material-icons photo

                    button(v-else='', v-on:click='avatar = null', type='button')
                        i.material-icons clear

                    input(v-show='!avatar',
                            type='file',
                            name='avatar',
                            v-on:change='onFileChange($event)',
                            ref='fileInput')

                input.input-global(@keyup.enter='addGroup',
                                    v-model='groupName',
                                    name='name',
                                    type='text',
                                    placeholder='Group name...')

                button(type='button', @click='addGroup', v-bind:disabled='btnDisabled')
                    i.material-icons add

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
              listUsers: null,
              access: false,
              selectedUsers: [],
              selectedIds: []
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
                this.selectedIds = [];
                this.selectedUsers = [];
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
                if (msg.id) msg = msg.id[0];

                this.showNotification(msg, 'validation');
            },

            // ---------------------------------------------------

            done(msg) {
                this.showNotification(msg, 'done');
                this.resetForm();
                this.$eventBus.$emit('update', {type: 'group'});
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

            btnDisabled() {
                if (this.groupName.length < 3 || this.selectedUsers.length === 0) return true;
            },

            // ---------------------------------------------------

            formData() {
                let formData = new FormData();

                formData.append('name', this.groupName);
                if (this.avatar) formData.append('avatar', this.$refs.fileInput.files[0]);

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
