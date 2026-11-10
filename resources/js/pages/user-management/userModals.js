document.addEventListener('alpine:init', () => {
    window.Alpine.data('userModal', () => ({
        isOpen: false,
        isEditing: false,
        formAction: '',

        storeUrl: '/usermanagement/users',

        form: {
            id: null,
            username: '',
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            role: 'buyer',
        },

        openAdd() {
            console.log("modal openAdd() called");
            this.isEditing = false;
            this.formAction = this.storeUrl;

            this.form = {
                id: null,
                username: '',
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                role: 'buyer',
            };

            this.isOpen = true;
        },

        openEdit(user) {
            this.isEditing = true;
            this.formAction = user.updateUrl;

            this.form = {
                id: user.id,
                username: user.username,
                first_name: user.first_name,
                last_name: user.last_name,
                email: user.email,
                password: '',
                role: user.role,
            };

            this.isOpen = true;
        },

        close() {
            this.isOpen = false;
        },
    }));
});