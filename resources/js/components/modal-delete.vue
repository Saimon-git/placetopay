<template>
    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center" :id="id">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
        <div class="modal-container bg-white w-11/12 md:max-w-lg mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <!-- Add margin if you want to see some of the overlay behind the modal-->
            <div class="modal-content py-4 text-left px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-xl font-bold">{{ title }}</p>
                    <div class="modal-close cursor-pointer z-50">
                        <svg @click="closeModal" class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>
                <!--Footer-->
                <div class="flex justify-end pt-2">
                    <slot name="btnDelete"></slot>
                    <button @click="closeModal" class="modal-close px-4 bg-red-500 p-3 rounded-lg text-white ">
                        No
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ModalDelete",
        props: ['title', 'id'],
        methods:{
            toggleModal() {
                const body = document.querySelector('body');
                const modal = document.getElementById(this.id);
                modal.classList.toggle('opacity-0');
                modal.classList.toggle('pointer-events-none');
                body.classList.toggle('modal-active');
            },
            closeModal(){
                this.toggleModal();
            },
        }
    }
</script>

<style scoped>

</style>