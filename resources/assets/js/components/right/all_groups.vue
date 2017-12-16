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
    h4 {
        margin: 20px 0;
        color: #777777;
    }
    hr {
        border: 0;
        height: 2px;
        box-shadow: 0px 1px 0px 0px rgba(0,0,0,.3);
        margin: 20px 0;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: auto;
        box-shadow: 0px 0px 2px 0px rgba(119,119,119, .5);
    }

    /* Zebra striping */
    tr:nth-of-type(odd) {
        background: #fbfbfb;
    }

    th {
        background: #f1f1f1;
        color: #777777;
        font-size: 0.8em;
        text-align: center;
        padding: 15px;
        border-bottom: 1px solid #ccc;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #ccc;
        text-align: center;
        color: #777777;
        font-size: 0.9em;
        font-weight: inherit;
    }
    .group_avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
    }
    button {
        border: none;
        background-color: transparent;
        outline: none;
        cursor: pointer;
    }
</style>

<script>
    export default {
        mounted() {
            console.log('Right ok!')
        }
    }
</script>
