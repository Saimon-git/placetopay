let mixin = {
    methods: {
        toggleModal(modalId) {
            const body = document.querySelector('body');
            const modal = document.getElementById(modalId);
            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            body.classList.toggle('modal-active');
        },

        closeModal(){
            this.toggleModal();
        }
    }
};

export default mixin;