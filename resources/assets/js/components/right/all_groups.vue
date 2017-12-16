<template>
    <div id="all_groups_app">

                <router-link to="/groups" exact-active-class="active_icon">
                    <i class="material-icons">arrow_back</i>
                </router-link>

                <h4>All groups</h4>

                <hr>

                <table>
                    <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Owner</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <img class="group_avatar" alt="profilepicture" src="https://avatars.io/twitter/rosa">
                        </td>
                        <td>Música</td>
                        <td>Ismael</td>
                    </tr>
                    <tr>
                        <td>
                            <img class="group_avatar" alt="profilepicture" src="https://avatars.io/twitter/marta">
                        </td>
                        <td>Material</td>
                        <td>Victor</td>
                    </tr>
                    <tr>
                        <td>
                            <img class="group_avatar" alt="profilepicture" src="https://avatars.io/twitter/chiste">
                        </td>
                        <td>Famoso</td>
                        <td>Marcos</td>
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
