<template>
    <div>

        <md-field class="arcoders-search">
            <label>Search...</label>
            <md-input></md-input>
            <md-icon>search</md-icon>
        </md-field>


        <md-content class="md-scrollbar">

            <md-list>

                <md-list-item>
                    <md-avatar>
                        <img src="https://placeimg.com/40/40/people/1" alt="People">
                    </md-avatar>

                    <span class="md-list-item-text">Alex Nelson</span>

                    <md-button class="md-icon-button md-list-action">
                        <md-icon class="md-primary">chat_bubble</md-icon>
                    </md-button>
                </md-list-item>
                <md-divider class="md-inset"></md-divider>
                <md-list-item>
                    <md-avatar>
                        <img src="https://placeimg.com/40/40/people/6" alt="People">
                    </md-avatar>

                    <span class="md-list-item-text">Mary Johnson</span>

                    <md-button class="md-icon-button md-list-action">
                        <md-icon>chat_bubble</md-icon>
                    </md-button>
                </md-list-item>
                <md-divider class="md-inset"></md-divider>
                <md-list-item>
                    <md-avatar>
                        <img src="https://placeimg.com/40/40/people/10" alt="People">
                    </md-avatar>

                    <span class="md-list-item-text">Mary Johnson</span>

                    <md-button class="md-icon-button md-list-action">
                        <md-icon>chat_bubble</md-icon>
                    </md-button>
                </md-list-item>
                <md-divider class="md-inset"></md-divider>
                <md-list-item>
                    <md-avatar>
                        <img src="https://placeimg.com/40/40/people/8" alt="People">
                    </md-avatar>

                    <span class="md-list-item-text">Mary Johnson</span>

                    <md-button class="md-icon-button md-list-action">
                        <md-icon>chat_bubble</md-icon>
                    </md-button>
                </md-list-item>
                <md-divider class="md-inset"></md-divider>
                <md-list-item>
                    <md-avatar>
                        <img src="https://placeimg.com/40/40/people/9" alt="People">
                    </md-avatar>

                    <span class="md-list-item-text">Mary Johnson</span>

                    <md-button class="md-icon-button md-list-action">
                        <md-icon>chat_bubble</md-icon>
                    </md-button>
                </md-list-item>
                <md-divider class="md-inset"></md-divider>
                <md-list-item>
                    <md-avatar>
                        <img src="https://placeimg.com/40/40/people/11" alt="People">
                    </md-avatar>

                    <span class="md-list-item-text">Mary Johnson</span>

                    <md-button class="md-icon-button md-list-action">
                        <md-icon>chat_bubble</md-icon>
                    </md-button>
                </md-list-item>
                <md-divider class="md-inset"></md-divider>
                <md-list-item>
                    <md-avatar>
                        <img src="https://placeimg.com/40/40/people/13" alt="People">
                    </md-avatar>

                    <span class="md-list-item-text">Mary Johnson</span>

                    <md-button class="md-icon-button md-list-action">
                        <md-icon>chat_bubble</md-icon>
                    </md-button>
                </md-list-item>
                <md-divider class="md-inset"></md-divider>
                <md-list-item>
                    <md-avatar>
                        <img src="https://placeimg.com/40/40/people/21" alt="People">
                    </md-avatar>

                    <span class="md-list-item-text">Mary Johnson</span>

                    <md-button class="md-icon-button md-list-action">
                        <md-icon>chat_bubble</md-icon>
                    </md-button>
                </md-list-item>
                <md-divider class="md-inset"></md-divider>
                <md-list-item>
                    <md-avatar>
                        <img src="https://placeimg.com/40/40/people/23" alt="People">
                    </md-avatar>

                    <span class="md-list-item-text">Mary Johnson</span>

                    <md-button class="md-icon-button md-list-action">
                        <md-icon>chat_bubble</md-icon>
                    </md-button>
                </md-list-item>

            </md-list>

        </md-content>

    </div>
</template>

<style lang="scss" scoped>
    .md-list {
        position: relative;
        width: 320px;
        max-width: 100%;
        vertical-align: top;
        border: 0px solid rgba(#000, .12);
    }
    .md-scrollbar {
        overflow-y: auto;
    }
    .md-content {
        max-width: 100%;
        max-height: 450px;
    }

</style>

<script>
    export default {
        name: 'SingleLine'
    }
</script>
