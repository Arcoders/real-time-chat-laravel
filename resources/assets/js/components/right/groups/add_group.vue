<template>
    <div id="add_group_app">

        <router-link to="/groups/my">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <avatar :username="groupName" color="#fff" :src="avatar"></avatar>

        <h4> Add new group </h4>

        <hr>

        <div class="wrap-input">
                <form class="input" v-on:submit.prevent="" method="POST" enctype="multipart/form-data">

                    <label class="fileContainer font-online">
                        <button type="button">
                            <i v-if="!avatar" class="material-icons">photo</i>
                            <a v-on:click="clearAvatar" v-else>
                                <i class="material-icons">clear</i>
                            </a>
                        </button>
                        <input v-if="!avatar" type="file" name="fileInput" v-on:change="onFileChange($event)" ref="fileInput">
                    </label>

                    <input @keyup.enter="addGroup" v-model="groupName" type="text" class="input-global" placeholder="Group name...">

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
              error: false
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

                this.$http.post('/new_group', {name: this.groupName}).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
                        console.log(this.groupName + ' - Groupo agregado...');
                        this.groupName = '';
                    } else {
                        this.error = true;
                    }

                }, response => {
                    this.loading = false;
                    this.error = true;
                });
            }
        },
        computed: {
            btnSubmit() {
                return ( this.groupName.length <= 3);
            }
        }
    }
</script>
