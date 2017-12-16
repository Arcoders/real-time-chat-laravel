<template>
    <div id="manage_groups_app">

        <div class="chat-head">
            <i class="material-icons big_icon">group_add</i>
            <div class="chat-name">
                <h1 class="font-name">Groups</h1>
                <p class="font-online">You can create public chat rooms for all users...</p>
            </div>
            <i class="fa fa-whatsapp fa-lg" aria-hidden="true"></i>
        </div>

        <div class="wrap-content">
            <div class="dynamic_content">

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
                            <button>
                                <i class="material-icons green_teal">mode_edit</i>
                            </button>
                        </td>
                        <td>
                            <button>
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
                            <button>
                                <i class="material-icons green_teal">mode_edit</i>
                            </button>
                        </td>
                        <td>
                            <button>
                                <i class="material-icons cool_red">delete</i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>

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
        </div>

    </div>
</template>

<style scoped>
    #manage_groups_app {
        background-color: #ffffff;
        border-radius: 2px;
        height: calc(98vh - 25px);
    }
    .big_icon {
        margin: 10px 20px;
        border-radius: 50%;
        font-size: 40px;
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
    .dynamic_content {
        padding: 20px;
        background-color: #ffffff;
        height: calc(98vh - 125px);
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
    .green_teal {
        color: #009688;
    }
    .cool_red {
        color: #E57373;
    }

</style>

<script>
    export default {
        mounted() {
            console.log('Right ok!')
        }
    }
</script>
