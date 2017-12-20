<template>
    <div id="add_group_app">

        <notifications :show="type" :message="result" :active="active"></notifications>

        <router-link to="/groups/my">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <avatar :username="groupName" color="#fff" :src="avatar"></avatar>

        <h4> Add new group small</h4>

        <hr>

        <div class="wrap-input">

                <form class="input" v-on:submit.prevent="addGroup()" method="POST" enctype="multipart/form-data">

                    <label class="fileContainer font-online">

                        <button v-if="!avatar" type="button">
                            <i class="material-icons">photo</i>
                        </button>

                        <button v-else v-on:click="clearAvatar" type="button">
                            <i class="material-icons">clear</i>
                        </button>

                        <input v-if="!avatar"
                               type="file"
                               name="fileInput"
                               v-on:change="onFileChange($event)"
                               ref="fileInput">

                    </label>

                    <input @keyup.enter="addGroup"
                           v-model="groupName"
                           type="text"
                           class="input-global"
                           placeholder="Group name...">

                    <button type="button" @click="addGroup" v-bind:disabled="btnSubmit">
                        <i class="material-icons">add</i>
                    </button>

                </form>
        </div>

        <loading v-if="loading"></loading>

    </div>
</template>

<style scoped>
    a {
        text-decoration: none;
        color: #777777;
    }
    .fileContainer i{
        font-size: 23px;
        color: #777777;
    }
</style>

<script>
    export default {
        data() {
          return {
              groupName: '',
              avatar: null,
              loading: false,
              active: false,
              type: 'default',
              result: 'Default message...',
              time: 4000
          }
        },
        mounted() {
            console.log('Add group ok!');
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.avatar = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            clearAvatar() {
                this.avatar = null;
            },
            addGroup() {
                if (this.btnSubmit) return;
                this.loading = true;

                this.$http.post('/new_group', {name: this.groupName, avatar: this.groupAvatar}).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
                        this.done(response.data);
                    } else {
                        this.error();
                    }

                }, response => {

                    this.loading = false;

                    if (response.status == 422) {
                        this.validation(response.data.errors.name)
                    } else {
                        this.error();
                    }

                });
            },
            error() {
                this.result = 'Group can not be added, try it later';
                this.type = 'error';
                this.active = true;
                this.resetNotification();
            },
            validation(msg) {
                this.result = msg;
                this.type = 'validation';
                this.active = true;
                this.resetNotification();
            },
            done(msg) {
                this.result = msg;
                this.type = 'done';
                this.active = true;
                this.clearAvatar();
                this.groupName = '';
                this.resetNotification();
            },
            resetNotification() {
                setTimeout(() => {
                    this.active = false;
                    this.type = 'Default';
                    this.result = 'Default message';
                }, this.time);
            }
        },
        computed: {
            btnSubmit() {
                return ( this.groupName.length < 3);
            },
            groupAvatar() {
                if (this.avatar) {

                    let formData = new FormData();
                    formData.append('fileInput', this.$refs.fileInput.files[0]);

                    return formData;

                } else {
                    return;
                }
            }
        }
    }
</script>
