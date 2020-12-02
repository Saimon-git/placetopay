<template>
  <div class="w-full" id="statModal" >
    <div class="w-full flex md:flex-row bg-gray-900 p-8">
      <div class="w-full md:w-6/12 h-12">
        <h2 class="text-white ml-2">
          Welcome back, {{ $store.state.auth.username }}!
        </h2>
      </div>
    </div>

    <div class="flex w-12/12 mt-5 mr-5 ml-5 p-2 pt-4 bg-white">
      <div class="flex w-full">
      </div>
    </div>

    <div class="flex mt-1 mr-5 ml-5 p-2 pt-4 bg-white">
      <loading
        v-if="$apollo.loading"
        :center="true"
        :loading="true"
        :color="'#8BC63E'"
      />

      <div
        v-else
        class="flex w-full mt-1 mb-5"
      >
      </div>
    </div>
  </div>
</template>

<script>


    export default {
        components: {},

        data() {
            return {
                current_date: moment().format('YYYY-MM-DD'),

            }
        },

        computed: {
        },

        created() {
        },

        apollo: {
        },

        methods: {
        }
    }
</script>
