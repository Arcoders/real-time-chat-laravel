<template>
    <div id="my_groups_app">

        <router-link to="/groups" exact-active-class="active_icon">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <h4>My groups</h4>

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
            <tr>
                <td>
                    <img class="group_avatar" alt="profilepicture" src="https://avatars.io/twitter/bones">
                </td>
                <td>Laravel</td>
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
            <tr>
                <td>
                    <img class="group_avatar" alt="profilepicture" src="https://avatars.io/twitter/adios">
                </td>
                <td>Nodejs</td>
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
            </tbody>
        </table>

    </div>
</template>

<style scoped>
    a {
        text-decoration: none;
        color: #777777;
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Right ok!')
        }
    }
</script>
