<template>
    <div id="right_app">

        <div class="chat-head">
            <md-icon class="md-size-2x margin_icon">group</md-icon>
            <div class="chat-name">
                <h1 class="font-name">Manage private groups</h1>
                <p class="font-online">With auto select and alternate headers...</p>
            </div>
        </div>

        <div class="chat">
            <md-table v-model="people" md-card @md-selected="onSelect">
                <md-table-toolbar>
                    <h3 class="md-title">With auto select and alternate headers</h3>
                </md-table-toolbar>

                <md-table-toolbar slot="md-table-alternate-header" slot-scope="{ count }">
                    <div class="md-toolbar-section-start">{{ getAlternateLabel(count) }}</div>

                    <div class="md-toolbar-section-end">
                        <md-button class="md-icon-button">
                            <md-icon>delete</md-icon>
                        </md-button>
                    </div>
                </md-table-toolbar>

                <md-table-row slot="md-table-row" slot-scope="{ item }" :md-disabled="item.name.includes('Stave')" md-selectable="multiple" md-auto-select>
                    <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
                    <md-table-cell md-label="Email" md-sort-by="email">{{ item.email }}</md-table-cell>
                    <md-table-cell md-label="Gender" md-sort-by="gender">{{ item.gender }}</md-table-cell>
                    <md-table-cell md-label="Job Title" md-sort-by="title">{{ item.title }}</md-table-cell>
                </md-table-row>
            </md-table>
        </div>

    </div>
</template>

<style lang="scss" scoped>
    #right_app {
        background-color: #ffffff;
        border-radius:  0 2px 2px 0;
        height: calc(98vh - 25px);
    }
    .md-table + .md-table {
        margin-top: 16px
    }
    .margin_icon {
        margin: 5px 20px;
    }
    .chat {
        height: calc(98vh - 85px);
        padding: 0;
        background-color: #ffffff;
    }
</style>

<script>
    export default {
        data: () => ({
            selected: [],
            people: [
                {
                    name: 'Shawna Dubbin',
                    email: 'sdubbin0@geocities.com',
                    gender: 'Male',
                    title: 'Assistant Media Planner'
                },
                {
                    name: 'Odette Demageard',
                    email: 'odemageard1@spotify.com',
                    gender: 'Female',
                    title: 'Account Coordinator'
                },
                {
                    name: 'Lonnie Izkovitz',
                    email: 'lizkovitz3@youtu.be',
                    gender: 'Female',
                    title: 'Operator'
                },
                {
                    name: 'Thatcher Stave',
                    email: 'tstave4@reference.com',
                    gender: 'Male',
                    title: 'Software Test Engineer III'
                },
                {
                    name: 'Clarinda Marieton',
                    email: 'cmarietonh@theatlantic.com',
                    gender: 'Female',
                    title: 'Paralegal'
                },
                {
                    name: 'Clarinda Marieton',
                    email: 'cmarietonh@theatlantic.com',
                    gender: 'Female',
                    title: 'Paralegal'
                },
                {
                    name: 'Clarinda Marieton',
                    email: 'cmarietonh@theatlantic.com',
                    gender: 'Female',
                    title: 'Paralegal'
                },
                {
                    name: 'Clarinda Marieton',
                    email: 'cmarietonh@theatlantic.com',
                    gender: 'Female',
                    title: 'Paralegal'
                },
                {
                    name: 'Clarinda Marieton',
                    email: 'cmarietonh@theatlantic.com',
                    gender: 'Female',
                    title: 'Paralegal'
                },
                {
                    name: 'Clarinda Marieton',
                    email: 'cmarietonh@theatlantic.com',
                    gender: 'Female',
                    title: 'Paralegal'
                },
                {
                    name: 'Clarinda Marieton',
                    email: 'cmarietonh@theatlantic.com',
                    gender: 'Female',
                    title: 'Paralegal'
                },
                {
                    name: 'Clarinda Marieton',
                    email: 'cmarietonh@theatlantic.com',
                    gender: 'Female',
                    title: 'Paralegal'
                },
                {
                    name: 'Clarinda Marieton',
                    email: 'cmarietonh@theatlantic.com',
                    gender: 'Female',
                    title: 'Paralegal'
                }
            ]
        }),
        methods: {
            onSelect (items) {
                this.selected = items
            },
            getAlternateLabel (count) {
                let plural = ''

                if (count > 1) {
                    plural = 's'
                }

                return `${count} user${plural} selected`
            }
        },
        mounted() {
            console.log('Right ok!')
        }
    }
</script>
