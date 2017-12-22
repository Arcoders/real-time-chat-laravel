<template>
    <div id="my_groups_app">


        <notifications :vue_notifications="notifications"></notifications>

        <loading v-if="loading"></loading>

        <div class="data">
            <router-link to="/groups">
                <i class="material-icons">arrow_back</i>
            </router-link>

            <h4>
                My groups
                <router-link to="/groups/add">
                    <i class="add material-icons">add</i>
                </router-link>
            </h4>

            <hr>
        </div>

        <table>
            <thead>
            <tr>
                <th>Avatar</th>
                <th>Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
                    <tr class="data" v-for="(group, index) in groups">
                        <td>
                            <avatar v-if="!group.avatar"
                                    class="group_avatar"
                                    :size="45"
                                    :username="group.name"
                                    color="#fff">
                            </avatar>

                            <avatar v-else
                                    class="group_avatar"
                                    :size="45"
                                    :username="group.name"
                                    :src="'/images/avatars/' + group.avatar">
                            </avatar>
                        </td>

                        <td>{{ group.name }}</td>

                        <td>
                            <router-link :to="{ name: 'edit_group', params: { group_id: group.id, group_name: group.name }}">
                                <i class="material-icons green_teal">mode_edit</i>
                            </router-link>
                        </td>

                        <td>
                            <button class="format_button" v-on:click="deleteGroup(group.id, index)">
                                <i class="material-icons cool_red">delete</i>
                            </button>
                        </td>
                </tr>

                    <tr v-if="notFound">
                        <td colspan="4">
                            No records found please
                            <router-link to="/groups/my/add" class="green_teal link_add">
                                Add Group
                            </router-link>
                        </td>
                    </tr>

                    <tr v-if="errorLoad">
                        <td colspan="4">
                            <p class="error">
                                Sorry :( records could not be loaded
                            </p>
                        </td>
                    </tr>
            </tbody>
        </table>

        <paginate :source="pagination" @navigate="clickedPage"></paginate>

    </div>
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

                        if (this.groups == 0) {
                            this.clickedPage(this.actualPage - 1);
                        } else {
                            this.clickedPage(this.actualPage);
                        }

                        console.log(this.groups);


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
                this.notifications.push({
                    message: msg,
                    type: 'done'
                });
                this.resetNotification();
            },

            // ---------------------------------------------------

            error() {
                this.notifications.push({
                    message: 'Group could not be deleted, try later',
                    type: 'error'
                });
                this.resetNotification();
            },

            // ---------------------------------------------------

            resetNotification() {
                setTimeout(() => {
                    this.notifications.shift();
                }, this.time);
            }

            // ---------------------------------------------------
        }
    }
</script>
