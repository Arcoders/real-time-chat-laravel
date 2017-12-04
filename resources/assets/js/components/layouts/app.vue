<template>
    <div class="page-container">
        <md-app md-waterfall md-mode="overlap">
            <md-app-toolbar class="md-primary md-large">
                <div class="md-toolbar-row separator">

                    <md-button class="md-icon-button">
                        <md-icon>home</md-icon>
                    </md-button>

                    <md-menu>
                        <md-button>Profile</md-button>
                        <md-button>Add Room</md-button>
                        <md-button>My Rooms</md-button>
                    </md-menu>

                </div>
            </md-app-toolbar>


            <md-app-content></md-app-content>
        </md-app>
    </div>
</template>

<style lang="scss" scoped>
    .md-app {
        height: 100vh;
        border: 5px solid rgba(#000, .12);
    }
    .separator {
        margin-top: 25px;
    }
</style>

<script>
    export default {
        name: 'Waterfall',
        data: () => ({
            menuVisible: false
        })
    }
</script>