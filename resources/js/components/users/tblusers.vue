<template>
    <div class="w-full">
        <table class="table-auto w-full mt-2 text-left">
            <thead>
                <tr class="border-b">
                    <th class="px-4 py-2 text-xs">NAME</th>
                    <th class="px-4 py-2 text-xs">USERNAME</th>
                    <th class="px-4 py-2 text-xs">EMAIL</th>
                    <th class="px-4 py-2 text-xs">&nbsp;</th>
                </tr>
            </thead>

            <tbody >
                <tr class="border-b" v-for="user in users" :key="user.id">
                    <td class="px-4 py-2">
                        <img :src="user.avatar" alt="Avatar" class="rounded-full user-avatar-image items-center justify-center">
                        <span>{{ user.first_name }} {{ user.last_name }}</span>
                    </td>
                    <td class="px-4 py-2">{{ user.username }}</td>
                    <td class="px-4 py-2">{{ user.email }}</td>
                    <td class="px-4 py-2">
                        <dropdown>
                            <svg slot="title" class="fill-current cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M9 4.58V4c0-1.1.9-2 2-2h2a2 2 0 0 1 2 2v.58a8 8 0 0 1 1.92 1.11l.5-.29a2 2 0 0 1 2.74.73l1 1.74a2 2 0 0 1-.73 2.73l-.5.29a8.06 8.06 0 0 1 0 2.22l.5.3a2 2 0 0 1 .73 2.72l-1 1.74a2 2 0 0 1-2.73.73l-.5-.3A8 8 0 0 1 15 19.43V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.58a8 8 0 0 1-1.92-1.11l-.5.29a2 2 0 0 1-2.74-.73l-1-1.74a2 2 0 0 1 .73-2.73l.5-.29a8.06 8.06 0 0 1 0-2.22l-.5-.3a2 2 0 0 1-.73-2.72l1-1.74a2 2 0 0 1 2.73-.73l.5.3A8 8 0 0 1 9 4.57zM7.88 7.64l-.54.51-1.77-1.02-1 1.74 1.76 1.01-.17.73a6.02 6.02 0 0 0 0 2.78l.17.73-1.76 1.01 1 1.74 1.77-1.02.54.51a6 6 0 0 0 2.4 1.4l.72.2V20h2v-2.04l.71-.2a6 6 0 0 0 2.41-1.4l.54-.51 1.77 1.02 1-1.74-1.76-1.01.17-.73a6.02 6.02 0 0 0 0-2.78l-.17-.73 1.76-1.01-1-1.74-1.77 1.02-.54-.51a6 6 0 0 0-2.4-1.4l-.72-.2V4h-2v2.04l-.71.2a6 6 0 0 0-2.41 1.4zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg>
                            <template slot="list">
                                <li class="">
                                    <a @click="show(user,'dlgResetPassword')" class="hover:bg-green hover:text-white rounded-t py-2 px-4 block whitespace-no-wrap" href="#">
                                        Reset Password
                                    </a>
                                </li>
                                <li class="">
                                    <a @click="show(user,'dlgDeleteUser')" class="hover:bg-green hover:text-white rounded-b py-2 px-4 block whitespace-no-wrap" href="#">
                                        Delete Member
                                    </a>
                                </li>
                            </template>
                        </dropdown>
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination :pagination="pagination" @update="reload"></pagination>

        <modal id="dlgResetPassword" title="Reset Password" size="md:max-w-xl">
            <form class="w-full bg-white rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input v-model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************">
                    <p class="text-red-400 mt-2" v-if="errors['input.password']">{{ errors['input.password'][0] }}</p>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">
                        Confirm Password
                    </label>
                    <input v-model="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="confirm_password" type="password" placeholder="******************">
                    <p class="text-red-400 mt-2" v-if="errors['input.password_confirmation']">{{ errors['input.password_confirmation'][0] }}</p>
                </div>
            </form>

            <button slot="btnSave" @click="resetPassword" class="px-4 bg-green p-3 rounded-lg text-white mr-2">
                Save
            </button>
        </modal>

        <modal-delete id="dlgDeleteUser" title="Are you sure you want to remove the membership?">
            <button slot="btnDelete" @click="destroy" class="px-4 bg-green p-3 rounded-lg text-white mr-2">
                Yes
            </button>
        </modal-delete>
    </div>
</template>

<script>
    import DELETE_USER from "../../graphql/users/delete.graphql";
    import RESET_PASSWORD from "../../graphql/users/reset_password.graphql";

    import mixin from "../../mixins";

    export default {
        name: "users_active",

        mixins: [mixin],

        data() {
            return {
                page: 1,
                password: '',
                password_confirmation: '',
                users: [],
                user: {},
                pagination: {},
                errors: {}
            }
        },

        watch: {
            values() {
                this.users = this.values.data;
                this.pagination = this.values.paginatorInfo;
            }
        },

        props: ['values'],

        methods: {
            async show(user, modalId){
                this.user = user;

                this.toggleModal(modalId);
            },

            async destroy(){
                Vue.$toast.info('Deleting..');

                await this.$apollo.mutate({
                    mutation: DELETE_USER,
                    variables: {
                        id: this.user.id,
                    },
                })
                .then(() => {
                    Vue.$toast.clear();
                    Vue.$toast.success('The User has been Deleted');

                    this.toggleModal('dlgDeleteUser');
                    this.reload(1);
                });
            },

            async resetPassword(){
                Vue.$toast.info('Updating Password...');

                await this.$apollo.mutate({
                    mutation: RESET_PASSWORD,
                    variables: {
                        input: {
                            id: this.user.id,
                            password: this.password,
                            password_confirmation: this.password_confirmation
                        }
                    }
                })
                .then(() => {
                    Vue.$toast.clear();
                    Vue.$toast.success('The Password has been Updated');

                    this.toggleModal('dlgResetPassword');
                    this.reload(1);
                })
                .catch(error => {
                    let { graphQLErrors } = error;

                    if (graphQLErrors[0].extensions.category === "validation") {
                        this.errors = graphQLErrors[0].extensions.validation;
                    }
                });
            },

            async reload(page) {
                let query = {page_users: page};

                this.$emit('reload', query);
            }
        }
    }
</script>
