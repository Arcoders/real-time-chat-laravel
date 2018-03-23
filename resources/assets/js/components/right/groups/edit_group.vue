<template lang="pug">
    .chat_groups(v-if='showEdit')

        notifications(:vue_notifications='notifications', :width='50')

        .data
            router-link(to='/groups/my')
                i.material-icons arrow_back

            avatar(:username='groupName', color='#fff', :src='groupAvatar')

            h4  Edit group
            hr

        form(v-on:submit.prevent='', method='POST', enctype='multipart/form-data')
            .group_input

                label.upload_avatar

                    button.button_upload(v-if='!groupAvatar', type='button')
                        i.material-icons backup

                    button.button_upload(v-else, v-on:click='clearAvatar', type='button')
                        i.material-icons clear

                    input(v-show='!groupAvatar', type='file', name='avatar', v-on:change='onFileChange($event)', ref='fileInput')

                input.input_name(@keyup.enter='editGroup', v-model='groupName', name='name', type='text', placeholder='Group name...')

                button.button_send(type='button', @click='editGroup', v-bind:disabled='btnDisabled') save


            multiselect(v-if='access', v-model='selectedUsers',
                            :multiple='true',
                            track-by='id',
                            label='name',
                            :hide-selected='true',
                            :close-on-select='false',
                            :options='listUsers')
                template(slot='tag', slot-scope='props')
                    span.custom__tag
                        span  {{ props.option.name }}
                        span.custom__remove(@click='props.remove(props.option)') &nbsp; ❌

        loading(v-if='loading')

</template>

<script>

    import {mixin} from './group_mixins';

    export default {

        // ---------------------------------------------------

        mixins: [mixin],

        // ---------------------------------------------------

        mounted() {
            this.getGroup();
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

                //return console.log(this.formData);

                if (type === 'image' && this.newImage) return;

                let data = (type === 'image' ) ? {deleteImage: true} : this.formData;

                this.loading = true;

                this.$http.post(`/groups/edit/${this.group_id}`, data).then(res => {

                    this.loading = false;

                    (res.status === 200) ? this.done(res.data) : this.error();

                }, res => {

                    this.loading = false;

                    (res.status === 422) ? this.validation(res.data.errors) : this.error();

                });
            },

            // ---------------------------------------------------

            getGroup() {
                this.$http.get(`/groups/get/${this.group_id}`).then(res => {

                    if (res.status === 200) {

                        if (Object.keys(res.data.group).length === 0) return this.back();

                        this.groupName = res.data.group.name;
                        if (res.data.group.avatar) this.groupAvatar = res.data.group.avatar;
                        this.selectedUsers = res.data.group.users;

                        this.showEdit = true;

                        if (res.data.friends.length > 0) {

                            this.access = true;
                            this.listUsers = res.data.friends;

                        } else {
                            this.showNotification('Find friends to add them to the group', 'done');
                        }

                    } else {
                        this.back();
                    }

                }, () => {
                    this.back();
                });
            },

            // ---------------------------------------------------

            back() {
                return this.$router.push('/groups/my');
            }

            // ---------------------------------------------------
        },

        // ---------------------------------------------------

    }
</script>
