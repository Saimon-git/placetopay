<template>
    <div>
        <div class="flex md:flex-row bg-gray-900 p-8">
            <div class="w-full md:w-2/5 h-12">
                @auth
                <h2 class="text-white ml-2">
                    Welcome back, {{ user.username }}!
                </h2>
                @endauth
                <p class="text-white ml-2">

                </p>
            </div>
            <div class="w-full md:w-1/5 h-12 text-white text-center">
                <h2>
                    1,280
                </h2>
                <p class="">TOTAL TEAM MEMBERS</p>
            </div>
            <div class="w-full md:w-1/5 h-12 text-white text-center">
                <h2>
                    417
                </h2>
                <p>ACTIVE TEAM MEMBERS</p>
            </div>
            <div class="w-full md:w-1/5 h-12 text-white text-center">
                <h2>
                    303
                </h2>
                <p>DAILY ACTIONS</p>
            </div>
        </div>
        <h1>Playground</h1>
        <div v-if="$apollo.queries.loading">Loading...</div>
        <pre>{{user}}</pre>
    </div>
</template>

<script>
  import gql from 'graphql-tag'

  export default {
    name: "playground",
    mounted() {
      this.getUser();
    },
    data () {
      return {
        user: {},
      }
    },
    methods: {
      async getUser() {
        const response = await this.$apollo.query({
          query: gql('{me { id first_name last_name username email }}')
        });
        this.user = response.data;
      }
    }
  }
</script>

<style scoped>

</style>
