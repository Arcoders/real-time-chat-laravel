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

        <div class="wrap-chat">
            <div class="chat">

                <table>
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Job Title</th>
                        <th>Twitter</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit</td>
                    </tr>
                    <tr>
                        <td>Ismael</td>
                        <td>Haytam</td>
                        <td>Laravel</td>
                        <td>Edit...</td>
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
    .chat {
        padding: 10px;
        background-color: #ffffff;
        height: calc(98vh - 105px);
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

</style>

<script>
    export default {
        mounted() {
            console.log('Right ok!')
        }
    }
</script>
