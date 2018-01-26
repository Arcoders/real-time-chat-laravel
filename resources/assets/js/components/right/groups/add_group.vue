<template lang="pug">

    #add_group_app

        notifications(:vue_notifications='notifications', :width='50')

        router-link(to='/groups/my')
            i.material-icons arrow_back

        avatar(:username='groupName', color='#fff', :src='avatar')

        h4 Add new group
        hr

        form(v-on:submit.prevent='', method='POST', enctype='multipart/form-data')

            .input.wrap-input(v-if='access')

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

                this.$http.get('/list_friends').then(res => {

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

                this.$http.post('/new_group', this.formData).then(res => {

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
