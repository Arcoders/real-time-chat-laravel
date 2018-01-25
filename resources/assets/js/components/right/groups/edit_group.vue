<template lang="pug">
    #edit_group_app(v-if='showEdit')

        notifications(:vue_notifications='notifications')

        router-link(to='/groups/my')
            i.material-icons arrow_back

        avatar(:username='groupName', color='#fff', :src='groupAvatar')

        h4  Edit group
        hr

        form(v-on:submit.prevent='', method='POST', enctype='multipart/form-data')
            .input.wrap-input
                label.fileContainer.font-online

                    button(v-if='!groupAvatar', type='button')
                        i.material-icons photo

                    button(v-else='', v-on:click='clearAvatar', type='button')
                        i.material-icons clear

                    input(v-show='!groupAvatar',
                                type='file',
                                name='avatar',
                                v-on:change='onFileChange($event)',
                                ref='fileInput')

                input.input-global(@keyup.enter='editGroup',
                                    v-model='groupName',
                                    name='name',
                                    type='text',
                                    placeholder='Group name...')

                button(type='button', @click='editGroup', v-bind:disabled='btnDisabled')
                    i.material-icons add
            br
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

    import {mixin} from './group_mixins';

    export default {

        // ---------------------------------------------------

        mixins: [mixin],

        // ---------------------------------------------------

        mounted() {
            this.listFriends();
            this.getGroup();
            console.log('Edit group ok!');
        },

        // ---------------------------------------------------

        methods: {

            // ---------------------------------------------------

            clearAvatar() {
                this.groupAvatar = null;
                this.editGroup('image');
            },

            // ---------------------------------------------------

            editGroup(type = null) {

                if (this.btnSubmit) return;
                this.loading = true;

                let data = (type === 'image') ? {deleteImage: true} : this.formData;

                this.$http.post('/edit_group/' + this.group_id, data).then(res => {

                    this.loading = false;

                    if (res.status === 200) {
                        this.done(res.data);
                    } else {
                        this.error();
                    }

                }, res => {

                    this.loading = false;

                    if (res.status === 422) {
                        this.validation(res.data.errors);
                    } else {
                        this.error();
                    }

                });
            },

            // ---------------------------------------------------

            listFriends() {

                this.loading = true;

                this.$http.get('/list_friends').then(res => {

                    this.loading = false;

                    if (res.status === 200) {

                        if (res.data.length !== 0) {
                            this.listUsers = res.data;
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
                this.$http.get('/get_group/' + this.group_id).then(res => {

                    if (res.status === 200) {

                        if (res.data === 0) return this.$router.push('/groups/my');

                        this.showEdit = true;

                        this.groupName = res.data.name;
                        if (res.data.avatar) this.groupAvatar = res.data.avatar;
                        this.selectedUsers = res.data.users;

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

    }
</script>
