<template>
    <div class="page-container">
        <md-app  md-mode="overlap">
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

                    <div class="md-toolbar-section-end">
                        <md-avatar class="md-large arcoders-right">
                            <md-tooltip class="arcoders-tip" md-direction="left" :md-active="true">
                                Ismael Haytam
                            </md-tooltip>
                            <img src="https://placeimg.com/80/80/people/3" alt="Avatar">
                        </md-avatar>
                    </div>

                </div>
            </md-app-toolbar>

            <md-app-content>

                <div class="md-layout arcoders-height-10">

                    <div class="md-layout-item"></div>

                    <div class="md-layout-item"></div>

                </div>

                <div class="md-layout arcoders-height-90">

                    <div class="md-layout-item"></div>

                    <div class="md-layout-item"></div>

                </div>

            </md-app-content>
        </md-app>
    </div>
</template>

<style lang="scss" scoped>
    .md-app {
        height: 100vh;
        border: 2px solid rgba(#000, .12);
    }
    .separator {
        margin-top: 25px;
    }
    .arcoders-right {
        margin-right: 2%;
        margin-top: 10px;
    }
    .arcoders-tip {
        background-color: rgba(#000, .12);
        font-size: 14px;
    }
    .arcoders-height-10 {
        height: 10%;
    }
    .arcoders-height-90 {
        height: 90%;
        background: rgba(lavender, .12);
    }
</style>

<script>
    export default {
        data: () => ({
            tooltipActive: true
        })
    }
</script>