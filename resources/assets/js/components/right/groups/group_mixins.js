export const mixin = {

    // ---------------------------------------------------

    data() {
        return {
            groupName: '',
            groupAvatar: null,
            avatar: null,
            loading: false,
            notifications: [],
            time: 6000,
            group_id: this.$route.params.group_id,
            showEdit: false,
            newImage: false,
            listUsers: null,
            access: false,
            selectedUsers: [],
            selectedIds: []
        }
    },

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
            this.newImage = false;
            if (this.$route.name === 'add_group') this.resetForm();
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
            return (this.groupName.length < 3);
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