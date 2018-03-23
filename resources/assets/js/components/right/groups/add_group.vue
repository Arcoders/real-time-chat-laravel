<template lang="pug">

    .chat_groups

        notifications(:vue_notifications='notifications', :width='50')

        .data
            router-link(to='/groups/my')
                i.material-icons arrow_back

            avatar(:username='groupName', color='#fff', :src='avatar')

            h4 Add new group
            hr

        form(v-on:submit.prevent='', method='POST', enctype='multipart/form-data')

            .group_input

                label.upload_avatar

                    button.button_upload(v-if='!avatar', type='button')
                        i.material-icons backup

                    button.button_upload(v-else, v-on:click='avatar = null', type='button')
                        i.material-icons clear

                    input(v-show='!avatar', type='file', name='avatar', v-on:change='onFileChange($event)', ref='fileInput')

                input.input_name(@keyup.enter='addGroup', v-model='groupName', name='name', type='text', placeholder='Group name...')

                button.button_send(type='button', @click='addGroup', v-bind:disabled='btnDisabled') save


            multiselect(v-if='access', v-model='selectedUsers', :multiple='true', track-by='id', label='name',
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
            this.listFriends();
        },

        // ---------------------------------------------------

        methods: {

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

                this.$http.get('/groups/friends').then(res => {

                    this.loading = false;

                    if (res.status === 200) {

                        if (res.data.length > 0) {
                            this.listUsers = res.data;
                            this.access = true;
                        } else {
                            this.showNotification('Find friends to add them to the group', 'done')
                        }

                    } else {
                        this.error('friends');
                    }

                }, () => {
                    this.loading = false;
                    this.error('friends');
                });
            },

            // ---------------------------------------------------

            addGroup() {

                if (this.btnSubmit) return;
                this.loading = true;

                this.$http.post('/groups/create', this.formData).then(res => {

                    this.loading = false;
                    (res.status === 200) ? this.done(res.data) : this.error();

                }, res => {

                    this.loading = false;
                    (res.status === 422) ? this.validation(res.data.errors) : this.error();

                });
            },

            // ---------------------------------------------------

        },

    }
</script>
