<template>
    <div>
        <loading v-if="loading" :center="true"></loading>

        <div class="w-full p-6" v-else>
            <div class="mb-4 w-full mr-4">
                <input
                    v-validate="'required'"
                    name="username"
                    placeholder="Username"
                    v-model="create.username"
                    type="text"
                    class="login-form-input block w-full focus:outline-none focus:shadow-outline"
                    autofocus>

                <p class="text-red-500 text-xs italic mt-4">{{ vErrors.first('username') }}</p>

                <p v-if="errors['input.username']" class="text-red-500 text-xs italic mt-4">
                    {{ errors['input.username'][0] }}
                </p>
            </div>

            <div class="mb-4 w-full mr-4">
                <input
                    placeholder="First Name (Optional)"
                    v-model="create.first_name"
                    type="text"
                    class="login-form-input block w-full focus:outline-none focus:shadow-outline"
                    autofocus>
            </div>

            <div class="mb-4 w-full mr-4">
                <input
                    placeholder="Last Name (Optional)"
                    v-model="create.last_name"
                    type="text"
                    class="login-form-input block w-full focus:outline-none focus:shadow-outline"
                    autofocus>
            </div>

            <div class="flex flex-wrap">
                <div class="w-full px-1 sm:w-1/2 md:w-1/2">
                    <button
                        :class="{'bg-orange text-white': create.gender === 'FEMALE'}"
                        type="button"
                        class="w-full border text-center p-2 rounded mt-1 mb-1"
                        @click="setGender('FEMALE')">

                        Female
                    </button>
                </div>

                <div class="w-full px-1 sm:w-1/2 md:w-1/2">
                    <button
                        :class="{'bg-orange text-white': create.gender === 'MALE'}"
                        type="button"
                        class="w-full border text-center p-2 rounded mt-1 mb-1"
                        @click="setGender('MALE')">

                        Male
                    </button>
                </div>
            </div>

            <div class="mb-4 w-full mr-4">
                <input
                    disabled
                    v-validate="'required|email'"
                    name="email"
                    placeholder="Email Address"
                    v-model="create.email"
                    type="text"
                    class="login-form-input block w-full focus:outline-none focus:shadow-outline"
                    autofocus>

                <p class="text-red-500 text-xs italic mt-4">{{ vErrors.first('email') }}</p>

                <p v-if="errors['input.email']" class="text-red-500 text-xs italic mt-4">
                    {{ errors['input.email'][0] }}
                </p>
            </div>

            <div class="mb-4 w-full mr-4">
                <input
                    v-validate="'required'"
                    name="phone"
                    type="tel"
                    v-mask="'###-###-####'"
                    placeholder="Phone Number"
                    v-model="create.phone"
                    class="login-form-input block w-full focus:outline-none focus:shadow-outline"
                    autofocus>

                <p class="text-red-500 text-xs italic mt-4">{{ vErrors.first('phone') }}</p>
            </div>

            <div class="mb-4 w-full mr-4">
                <input
                    v-validate="'required|min:8'"
                    name="password"
                    placeholder="Password"
                    v-model="create.password"
                    type="password"
                    ref="password"
                    class="login-form-input block w-full focus:outline-none focus:shadow-outline"
                    autofocus>

                <p class="text-red-500 text-xs italic mt-4">{{ vErrors.first('password') }}</p>
            </div>

            <div class="mb-4 w-full mr-4">
                <input
                    v-validate="'confirmed:password'"
                    placeholder="Confirm Password"
                    name="password_confirmation"
                    v-model="create.password_confirmation"
                    type="password"
                    class="login-form-input block w-full focus:outline-none focus:shadow-outline"
                    autofocus>

                <p class="text-red-500 text-xs italic mt-4">{{ vErrors.first('password_confirmation') }}</p>
            </div>

            <div class="flex flex-wrap -mx-2 mb-4">
                <div class="w-full">
                    <button type="button" @click="register" class="btn bg-orange text-white w-full">
                        <span v-if="registering">Saving...</span>
                        <span v-else>Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import INVITATION from "../../../graphql/invitations/invitation.graphql";

    export default {
        data() {
            return {
                invitation: {},
                loading: false,
                registering: false,
                create: {
                    email: '',
                    gender: 'FEMALE'
                }
            }
        },

        props: ['errors', 'token'],

        created() {
            this.loadInvitation();
        },

        methods: {
            async loadInvitation() {
                this.loading = true;

                await this.$apollo.mutate({
                    mutation: INVITATION,
                    variables: {
                        uuid: this.token
                    }
                })
                .then(({data}) => {
                    this.create.email = data.invitation.email;
                    this.loading = false;
                });
            },

            async register() {
                await this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$emit('next', this.create, 2);
                    }
                });
            },

            setGender(element) {
                this.create.gender = element;
            }
        }
    }
</script>