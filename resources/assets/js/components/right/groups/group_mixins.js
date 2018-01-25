export const mixin = {

    // ---------------------------------------------------

    methods: {
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            let reader = new FileReader();

            if (!files.length) return;

            reader.onload = e => {
                this.avatar = e.target.result;
                this.groupAvatar = e.target.result;
            };

            reader.readAsDataURL(files[0]);

            if (this.$route.name === 'edit_group') this.newImage = true;


        },

        // ---------------------------------------------------

        error(type = null) {
            if (type === 'friends') {

                this.showNotification('Look for new friends firstly', 'error');

            } else {

                let vrb = (this.$route.name === 'edit_group') ? 'edited' : 'added';

                this.showNotification(`Group can not be ${vrb}, try it later`, 'error');
            }
        },

        // ---------------------------------------------------

        validation(msg) {
            if (msg.avatar) msg = msg.avatar[0];
            if (msg.name) msg = msg.name[0];
            if (msg.id) msg = msg.id[0];

            this.showNotification(msg, 'validation');
        },

        // ---------------------------------------------------

        done(msg) {
            this.showNotification(msg, 'done');
            if (this.$route.name === 'add_group') this.resetForm();
            this.$eventBus.$emit('update', {type: 'group', refresh: true});
        },

        // ---------------------------------------------------

        showNotification(msg, type) {
            this.notifications.push({ message: msg, type: type });
            setTimeout(() => {
                this.notifications.shift();
            }, this.time);
        },

        // ---------------------------------------------------
    },

    computed: {

        // ---------------------------------------------------

        btnDisabled() {
            if (this.groupName.length < 3) return true;
        },

        // ---------------------------------------------------

        formData() {
            let formData = new FormData();

            formData.append('name', this.groupName);
            if (this.avatar || this.newImage) formData.append('avatar', this.$refs.fileInput.files[0]);

            this.selectedIds = Object.keys(this.selectedUsers).map(s => this.selectedUsers[s].id);

            formData.append('id', this.selectedIds);

            return formData;
        }

        // ---------------------------------------------------

    }

};