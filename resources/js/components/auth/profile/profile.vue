<template>
  <form
    class="bg-white shadow-md rounded px-8 ml-4 mr-4 pt-6 pb-8 mt-10"
    @submit.prevent="update"
  >
    <div class="flex w-full h-12 m-4 inline-block">
      <div class="w-5/6 flex-none p-2">
        <h2 class="justify-start">
          Profile
        </h2>
      </div>
      <div class="w-1/6 flex-1 justify-end">
        <a
          class="float-right"
          @click="$router.go(-1)"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="30"
            height="30"
          >
            <path
              class="heroicon-ui"
              d="M16.24 14.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 0 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12l2.83 2.83z"
            />
          </svg>
        </a>
      </div>
    </div>

    <div>
      <div class="flex flex-wrap -mx-3 mb-6">
      </div>

      <div class="flex flex-wrap -mx-3 mb-6">

        <div class="w-full  px-3 mb-6 md:mb-0">
          <label
            class="block text-gray-700 font-bold mb-2 font-size-16"
            for="last_name"
          >
            Name
          </label>
          <input
            id="last_name"
            v-model="user.name"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            readonly="readonly"
          >
          <p
            v-if="errors['input.last_name']"
            class="text-red-400 mt-2"
          >
            {{ errors['input.last_name'][0] }}
          </p>
        </div>
      </div>

      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label
            class="block text-gray-700 font-bold mb-2 font-size-16"
            for="username"
          >
            Username
          </label>
          <input
            id="username"
            v-model="user.username"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            readonly="readonly"
          >
          <p
            v-if="errors['input.username']"
            class="text-red-400 mt-2"
          >
            {{ errors['input.username'][0] }}
          </p>
        </div>

        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <label
            class="block text-gray-700 font-bold mb-2 font-size-16"
            for="email"
          >
            E-mail
          </label>
          <input
            id="email"
            v-model="user.email"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
            type="email"
            readonly="readonly"
          >
          <p
            v-if="errors['input.email']"
            class="text-red-400 mt-2"
          >
            {{ errors['input.email'][0] }}
          </p>
        </div>
      </div>

      <div class="flex items-center justify-between mt-5">
      </div>
    </div>
  </form>
</template>

<script>
    import UPDATE_PROFILE from '../../../graphql/auth/update_profile.graphql';

    export default {
        name: "UpdateProfile",

        props: [],

        data() {
            return {
                edition: false,
                states: [],
                user: {},
                updating: false,
                errors: {},
                loading: false
            }
        },

        created() {
            this.getUser();
        },

        methods: {
            async getUser() {
                this.user = _.clone(this.$store.state.auth);
            },

            async update() {
                this.updating = true;

                Vue.$toast.clear();
                Vue.$toast.info('Updating...');

                await this.$apollo.mutate({
                    mutation: UPDATE_PROFILE,
                    variables: {
                        input: {
                            username: this.user.username,
                            name: this.user.first_name+' '+this.user.last_name,
                            email: this.user.email,
                            phone: this.user.phone
                        }
                    }
                })
                .then((response) => {
                    this.updating = false;
                    this.errors = {};
                    Vue.$toast.clear();
                    Vue.$toast.success('Your Profile has been updated');
                })
                .catch((errors) => {
                    this.updating = false;
                    Vue.$toast.clear();

                    let { graphQLErrors } = errors;

                    if (graphQLErrors[0].extensions.category === "validation") {
                        this.errors = graphQLErrors[0].extensions.validation;
                    }
                });
            },
        }
    }
</script>
