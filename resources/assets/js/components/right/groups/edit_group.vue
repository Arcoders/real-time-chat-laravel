<template>
    <div id="edit_group_app" v-if="showEdit">

        <notifications :show="type" :message="result" :active="active"></notifications>

        <router-link to="/groups/my">
            <i class="material-icons">arrow_back</i>
        </router-link>

        <avatar :username="groupName" color="#fff" :src="avatar"></avatar>

        <h4> Edit group </h4>

        <hr>

        <div class="wrap-input">

                <form class="input" v-on:submit.prevent="" method="PATCH" enctype="multipart/form-data">

                    <label class="fileContainer font-online">

                        <button v-if="!avatar" type="button">
                            <i class="material-icons">photo</i>
                        </button>

                        <button v-else v-on:click="clearAvatar" type="button">
                            <i class="material-icons">clear</i>
                        </button>

                        <input v-show="!avatar"
                               type="file"
                               name="avatar"
                               v-on:change="onFileChange($event)"
                               ref="fileInput">

                    </label>

                    <input @keyup.enter="addGroup"
                           v-model="groupName"
                           name="name"
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
              time: 4000,
              group_id: this.$route.params.group_id,
              showEdit: false
          }
        },
        mounted() {
            this.getGroup();
            console.log(this.groupName);
            console.log('Edit group ok!');
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;

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

                let formData = new FormData();
                formData.append('name', this.groupName);
                formData.append('avatar', this.$refs.fileInput.files[0]);

                this.$http.patch('/group/' + this.group_id, {name: this.groupName, avatar: formData}).then(response => {

                    this.loading = false;

                    if (response.status == 200) {
                        this.done(response.data);
                    } else {
                        this.error();
                    }

                }, response => {

                    this.loading = false;

                    if (response.status == 422) {
                        this.validation(response.data.errors);
                    } else {
                        this.error();
                    }

                });
            },
            error() {
                this.result = 'Group can not be edited, try it later';
                this.type = 'error';
                this.active = true;
                this.resetNotification();
            },
            validation(msg) {
                if (msg.name) this.result = msg.name[0];
                if (msg.avatar) this.result = msg.avatar[0];
                this.type = 'validation';
                this.active = true;
                this.resetNotification();
            },
            done(msg) {
                this.result = msg;
                this.type = 'done';
                this.active = true;
                this.resetNotification();
            },
            resetNotification() {
                setTimeout(() => {
                    this.active = false;
                    this.type = 'Default';
                    this.result = 'Default message';
                }, this.time);
            },
            getGroup() {
                this.$http.get('/get_group/' + this.group_id).then(response => {

                    if (response.status == 200) {

                        if (response.data == 0) return this.$router.push('/groups/my');

                        this.showEdit = true;

                        this.groupName = response.data.name;
                        if (response.data.avatar) this.avatar = '/images/avatars/' + response.data.avatar;

                    } else {
                        this.$router.push('/groups/my');
                    }

                }, () => {
                    this.$router.push('/groups/my');
                });
            },
        },
        computed: {
            btnSubmit() {
                return ( this.groupName.length < 3);
            }
        }
    }
</script>
