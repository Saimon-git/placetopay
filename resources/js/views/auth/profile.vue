<template>
    <div class="w-full">
        <div v-if="$apollo.loading" class="bg-white ml-4 mr-4 mt-10">
            <loading :loading="true" :center="true" :color="'#8BC63E'"></loading>
        </div>

        <div v-else>
            <auth-profile ></auth-profile>
        </div>
    </div>
</template>

<script>
    import AuthProfile from '../../components/auth/profile/profile';

    export default {
        name: "profile",

        components: {AuthProfile},

        data() {
            return {
            }
        },

        apollo: {

        }
    }
</script>
