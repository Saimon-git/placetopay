<template>
    <div>
        <header class="topbar bg-white z-40">
            <nav class="flex items-center justify-between flex-wrap bg-withe-500 p-6">
                <div class="block lg:hidden">
                    <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Menu</title>
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                        </svg>
                    </button>
                </div>
                <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto h-12">
                    <div class="text-sm lg:flex-grow">
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">

                        </a>
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">

                        </a>
                        <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white">

                        </a>
                    </div>

                    <div>
                        <div >

                            <div class="dropdown inline-block z-40">
                                <button class="font-semibold py-2 px-4 rounded inline-flex items-center" v-if="this.$store.state.auth">
                                    <img class="h-8 w-8 rounded-full object-cover" :src="$store.state.auth.avatar" alt="Avatar">
                                </button>
                                <ul class="dropdown-menu absolute right-0 origin-top-right hidden bg-white pt-1 rounded-lg shadow-2xl bg-white-50%">
                                    <li class="">
                                        <router-link class="block w-48 px-4 py-2 text-gray-800 hover:bg-green hover:text-white"
                                                     to="/profile">Profile</router-link>
                                    </li>
                                    <li class="" @click.prevent="logout">
                                        <a href="#" class="block w-48 px-4 py-2 text-gray-800 hover:bg-green hover:text-white">
                                            Sign out
                                        </a>
                                    </li>
                                </ul>

                                <form id="logout-form" action="/logout" method="POST">
                                    <input type="hidden" name="_token" :value="csrf_token">
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </nav>
        </header>
    </div>
</template>

<script>
import ME from "../graphql/auth/me.graphql";

export default {
    name: "header-component",

    data() {
        return {
            user: {},
            notifications: []
        }
    },

    props: ['super_admin'],

    apollo: {
        getData: {
            query: ME,
            manual: true,
            result ({ data, loading, networkStatus }) {
                let user = data.me;

                this.$store.commit('updateUser', user);
            }
        },
    },

    computed: {
        csrf_token() {
            return document.head.querySelector('meta[name="csrf-token"]').content;
        },
    },

    methods: {

        async logout() {
            this.$store.commit('clearState');
            document.getElementById('logout-form').submit();
        }
    }
}
</script>
