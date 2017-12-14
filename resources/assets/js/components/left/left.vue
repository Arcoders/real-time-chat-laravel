<template>
    <div id="left_app">

        <section class="left">

            <div class="profile">
                <img src="https://avatars.io/twitter/nada">
                <div class="icons">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <i class="fa fa-bell" aria-hidden="true"></i>
                    <i class="fa fa-power-off" aria-hidden="true"></i>
                </div>
            </div>

            <search></search>

            <div class="wrap-filter">
                <div class="link_filter">
                    <a href="#">Groups</a>
                </div>
                <div class="link_filter">
                    <a href="#">Private</a>
                </div>
            </div>

            <div class="contact-list">
                <groups></groups>
            </div>

        </section>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Left ok!')
        }
    }
</script>
