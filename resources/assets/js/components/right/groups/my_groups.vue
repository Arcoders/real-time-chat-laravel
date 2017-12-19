<template>
    <div id="my_groups_app">

        <router-link to="/groups">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <h4>
            My groups
            <router-link to="/groups/my/add">
                <i class="add material-icons">add</i>
            </router-link>
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
    .add {
        background-color: #fafafa;
        border-radius: 50%;
    }
    .add:hover {
        background-color: #f1f1f1;
        color: #009688;
    }
</style>

<script>
    export default {
        mounted() {
            console.log('My groups ok!')
        }
    }
</script>
