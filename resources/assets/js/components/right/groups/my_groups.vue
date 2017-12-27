<template lang="pug">
    #my_groups_app
        notifications(:vue_notifications='notifications')
        loading(v-if='loading')
        .data
            router-link(to='/groups')
                i.material-icons arrow_back
            h4 My groups
                router-link(to='/groups/add')
                    i.add.material-icons add
            hr
        table
            thead
                tr
                    th Avatar
                    th Name
                    th Edit
                    th Delete
            tbody
                tr.data(v-for='(group, index) in groups')
                    td
                        avatar.group_avatar(:size='45',
                                            :username='group.name',
                                            :src='group.avatar',
                                            color='#fff')
                    td {{ group.name }}
                    td
                        router-link(:to="editLink(group)")
                            i.material-icons.green_teal mode_edit
                    td
                        button.format_button(v-on:click='deleteGroup(group.id, index)')
                            i.material-icons.cool_red delete
                tr(v-if='notFound')
                    td(colspan='4') No records found please
                        router-link.green_teal.link_add(to='/groups/add') Add Group
                tr(v-if='errorLoad')
                    td(colspan='4')
                        p.error Sorry :( records could not be loaded
        paginate(:source='pagination', @navigate='clickedPage')

</template>

<style scoped>
    .data a {
        text-decoration: none;
        color: #777777;
    }
    .add {
        background-color: #fafafa;
        border-radius: 50%;
    }
    .add:hover {
        background-color: #f1f1f1;
        color: #009688;
    }
    .group_avatar {
        margin: auto;
    }
    .link_add {
        text-decoration: none;
    }
    .error {
        color: #E57373;
    }
</style>

<script>
    export default {

        // ---------------------------------------------------

        data() {
            return {
                loading: true,
                groups: [],
                pagination: {},
                actualPage: null,
                notFound: false,
                errorLoad: false,
                notifications: [],
                time: 4000
            }
        },

        // ---------------------------------------------------

        mounted() {
            this.myGroups('/my_groups');
            console.log('My groups ok!');
        },

        // ---------------------------------------------------

        methods: {

            // ---------------------------------------------------

            clickedPage(page) {
                this.myGroups('/my_groups?page=' + page);
            },

            // ---------------------------------------------------

            myGroups(url) {

                this.loading = true;

                this.$http.get(url).then(response => {

                    this.loading = false;

                    if (response.status == 200) {

                        this.groups = response.data.data;
                        this.pagination = response.data;
                        this.actualPage = this.pagination.current_page;

                        if (!this.groups || this.groups.length == 0) this.notFound = true;


                    } else {
                        this.errorLoad = true;
                    }

                }, () => {

                    this.loading = false;
                    this.errorLoad = true;

                });
            },

            // ---------------------------------------------------

            deleteGroup(group_id, index) {

                this.loading = true;

                this.$http.delete('/delete_group/' + group_id).then(response => {

                    this.loading = false;

                    if (response.status == 200) {

                        this.groups.splice(index, 1);

                        this.done(response.data);

                        if (this.groups == 0) return this.clickedPage(this.actualPage - 1);

                        this.clickedPage(this.actualPage);

                    } else {
                        this.error();
                    }

                }, () => {
                    this.loading = false;
                    this.error();
                });
            },

            // ---------------------------------------------------

            done(msg) {
                this.showNotification(msg, 'done');
            },

            // ---------------------------------------------------

            error() {
                this.showNotification('Group could not be deleted, try later', 'error');
            },

            // ---------------------------------------------------

            showNotification(msg, type) {
                this.notifications.push({ message: msg, type: type });
                setTimeout(() => {
                    this.notifications.shift();
                }, this.time);
            },

            // ---------------------------------------------------

            editLink(group) {
                return {
                    name: 'edit_group',
                    params: {
                        group_id: group.id,
                        group_name: group.name
                    }
                }
            }

            // ---------------------------------------------------
        }
    }
</script>
