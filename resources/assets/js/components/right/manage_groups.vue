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

                <div v-if="$route.path == '/groups'">

                    <div class="wrap-filter">
                        <div class="link_filter">
                            <router-link to="groups/all" exact-active-class="active">All groups</router-link>
                        </div>
                        <div class="link_filter">
                            <router-link to="groups/my">My groups</router-link>
                        </div>
                    </div>

                </div>

                <router-view></router-view>

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
