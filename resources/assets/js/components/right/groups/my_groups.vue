<template>
    <div id="my_groups_app">

        <router-link to="/groups">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <h4>
            My groups
            <span class="data">
                <router-link to="/groups/my/add">
                <i class="add material-icons">add</i>
                </router-link>
            </span>
        </h4>

        <hr>

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
                            <avatar class="group_avatar" :size="35" :username="group.name" color="#fff" :src="group.avatar"></avatar>
                        </td>

                        <td>{{ group.name }}</td>

                        <td>
                            <button class="format_button">
                                <i class="material-icons green_teal">mode_edit</i>
                            </button>
                        </td>

                        <td>
                            <button class="format_button">
                                <i class="material-icons cool_red">delete</i>
                            </button>
                        </td>
                </tr>

                <tr v-if="loading">
                    <td colspan="4">
                        <loading v-if="loading" :normal="true"></loading>
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

                    <tr v-if="error">
                        <td colspan="4">
                            <p class="error">
                                Sorry :( records could not be loaded
                            </p>
                        </td>
                    </tr>
            </tbody>
        </table>

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
        data() {
            return {
                loading: true,
                groups: [],
                notFound: false,
                error: false
            }
        },
        mounted() {
            this.myGroups();
            console.log('My groups ok!');
        },
        methods: {
            myGroups() {

                this.loading = true;

                this.$http.get('/my_groups').then(response => {

                    this.loading = false;

                    if (response.status == 200) {

                        this.groups = response.data;

                        if (this.groups.length == 0) this.notFound = true;

                    } else {
                        this.error = true;
                    }

                }, response => {

                    this.loading = false;
                    this.error = true;

                });
            }
        }
    }
</script>
