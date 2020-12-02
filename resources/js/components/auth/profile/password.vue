<template>
    <form class="bg-white shadow-md rounded px-8 ml-4 mr-4 pt-6 pb-8 mb-4" @submit.prevent="changePassword">
        <h1 class="mb-5">Password</h1>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-6/12 px-3 mb-6 md:mb-0">
                <label class="block text-gray-700 font-bold mb-2 font-size-16">
                    Old Password
                </label>
                <input v-model="old_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="old_password" type="password">
                <p class="text-red-400 mt-2" v-if="errors['input.old_password']">{{ errors['input.old_password'][0] }}</p>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-6/12 px-3 mb-6 md:mb-0">
                <label class="block text-gray-700 font-bold mb-2 font-size-16">
                    New Password
                </label>
                <input v-model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="new_password" type="password">
                <p class="text-red-400 mt-2" v-if="errors['input.password']">{{ errors['input.password'][0] }}</p>
            </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full md:w-6/12 px-3 mb-6 md:mb-0">
                <label class="block text-gray-700 font-bold mb-2 font-size-16">
                    Confirm Password
                </label>
                <input v-model="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="confirm_password" type="password">
            </div>
        </div>

        <div class="flex items-center justify-between mt-5">
            <button :disabled="updating" class="p-4 bg-green hover:bg-green text-white font-bold rounded focus:outline-none focus:shadow-outline" type="submit">
                <span v-if="updating">Updating...</span>
                <span v-else>Change</span>
            </button>
        </div>
    </form>
</template>

<script>
    import UPDATE_PASSWORD from '../../../graphql/auth/update_password.graphql';

    export default {
        name: "updatePassword",

        data() {
            return {
                old_password: '',
                password: '',
                password_confirmation: '',
                updating: false,
                errors: {}
            }
        },

        methods: {
            async changePassword() {
                this.updating = true;
                Vue.$toast.clear();
                Vue.$toast.info('Updating...');

                await this.$apollo.mutate({
                    mutation: UPDATE_PASSWORD,
                    variables: {
                        input: {
                            old_password: this.old_password,
                            password: this.password,
                            password_confirmation: this.password_confirmation
                        }
                    }
                })
                .then(() => {
                    this.old_password = '';
                    this.password = '';
                    this.password_confirmation = '';
                    this.updating = false;
                    this.errors = {};
                    Vue.$toast.clear();
                    Vue.$toast.success('Your Password has been updated');
                })
                .catch((error) => {
                    this.updating = false;
                    Vue.$toast.clear();

                    let { graphQLErrors } = error;

                    if (graphQLErrors[0].extensions.category === "validation") {
                        this.errors = graphQLErrors[0].extensions.validation;
                    }
                });
            }
        }
    }
</script>