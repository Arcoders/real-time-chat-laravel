<template lang="pug">
    .groups_table

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
                    th Status
            tbody

                tr.data(v-for='(group, index) in groups')
                    td
                        avatar.avatar(:size='45', :username='group.name', :src='group.avatar', color='#fff')
                    td {{ group.name }}
                    td
                        router-link(:to="editLink(group)")
                            i.material-icons.green mode_edit
                    td
                        button.format(v-if="!group.deleted_at", v-on:click="changeStatus(group.id, 'delete')")
                            i.material-icons.red delete

                        button.format(v-else, v-on:click="changeStatus(group.id, 'restore')")
                            i.material-icons.orange settings_backup_restore

                tr(v-if='notFound')
                    td(colspan='4') No records found please
                        router-link.green.link_add(to='/groups/add') Add Group

                tr(v-if='errorLoad')
                    td(colspan='4')
                        p.red Sorry :( records could not be loaded

        paginate(:source='pagination', @navigate='clickedPage')

</template>

<style scoped>

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
            this.myGroups('/groups/my');
        },

        // ---------------------------------------------------

        methods: {

            // ---------------------------------------------------

            clickedPage(page) {
                this.myGroups(`/groups/my?page=${page}`);
            },

            // ---------------------------------------------------

            myGroups(url) {

                this.loading = true;

                this.$http.get(url).then(response => {

                    this.loading = false;

                    if (response.status === 200) {

                        this.groups = response.data.data;
                        this.pagination = response.data;
                        this.actualPage = this.pagination.current_page;

                        if (!this.groups || this.groups.length === 0) this.notFound = true;


                    } else {
                        this.errorLoad = true;
                    }

                }, () => {

                    this.loading = false;
                    this.errorLoad = true;

                });
            },

            // ---------------------------------------------------

            changeStatus(group_id, type) {

                this.loading = true;

                this.$http.delete(`/groups/${type}/${group_id}`).then(response => {

                    this.loading = false;

                    if (response.status === 200) {

                        this.showNotification(response.data, 'done');

                        if (this.groups.length === 0) return this.clickedPage(this.actualPage - 1);

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

            error() {
                this.showNotification('Group could not be deleted, try later', 'error');
            },

            // ---------------------------------------------------

            showNotification(msg, type) {
                this.notifications.push({ message: msg, type: type });
                setTimeout(() => this.notifications.shift(), this.time);
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
