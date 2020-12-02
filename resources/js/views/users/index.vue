<template>
    <div class="flex w-full p-4">
        <div class="w-5/6">
            <div class="w-full mb-4 bg-white">
                <h3 class="text-center mt-2 p-4">
                    Using {{ licenses }} Licences
                </h3>
            </div>
            <div class="w-full mb-4 bg-white p-4">
                <div>
                    <ul class="flex border-b-2 border-gray-200">
                        <li class="w-24 text-center">
                            <a @click.prevent="active = 1" :class="{'active': active === 1}" class="text-lg bg-white align-middle inline-block py-2 px-4 text-black hover:text-gray-600" href="#">
                                Active
                            </a>
                        </li>
                        <li class="w-24 text-center">
                            <a @click.prevent="active = 2" :class="{'active': active === 2}" class="text-lg bg-white align-middle inline-block py-2 px-4 text-black hover:text-gray-600" href="#">
                                Admin
                            </a>
                        </li>
                    </ul>

                    <br>

                    <div class="w-full">
                        <div class="mb-4" id="active" v-show="active === 1">
                            <loading v-show="$apollo.loading" :center="true" :loading="true" :color="'#8BC63E'"></loading>
                            <users-active v-show="!$apollo.loading" :values="users" @reload="reload"></users-active>
                        </div>
                        <div class="mb-4" id="admin" v-show="active === 2">
                            <loading v-show="$apollo.loading" :center="true" :loading="true" :color="'#8BC63E'"></loading>
                            <admins v-show="!$apollo.loading" :values="admins" @reload="reload"></admins>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-1/6 bg-white-400">
            <router-link to="/users/invite" class="w-full inline-block bg-green text-white text-center p-4 rounded ml-3 mt-2">
                <svg class="fill-current inline-block text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path class="heroicon-ui" d="M17 11a1 1 0 0 1 0 2h-4v4a1 1 0 0 1-2 0v-4H7a1 1 0 0 1 0-2h4V7a1 1 0 0 1 2 0v4h4z"/>
                </svg>
                Invite User
            </router-link>
        </div>
    </div>
</template>

<script>
    import Admins from "./../../components/users/tbladmins";
    import UsersActive from "./../../components/users/tblusers";

    import MANAGEMENT from "../../graphql/users/management.graphql";

    export default {
        name: "users",

        components: {Admins, UsersActive},

        data() {
            return {
                active: 1,
                admins: {},
                users: {},
                invitations: {},
                page_invitations: 1,
                page_users: 1,
                page_admins: 1,
                licenses: 0,
                update: false
            }
        },

        apollo: {
            getData: {
                query: MANAGEMENT,
                variables() {
                    return {
                        page_users: this.page_users,
                        page_admins: this.page_admins,
                    }
                },
                manual: true,
                result ({ data, loading, networkStatus }) {
                    this.users = data.users;
                    this.admins = data.admins;

                    this.licenses = this.users.paginatorInfo.total;
                }
            }
        },

        methods: {
            async reload(query) {
                await this.$apollo.queries.getData.refetch({
                    page_users: query.page_users ? query.page_users : this.page_users,
                    page_admins: query.page_admins ? query.page_admins : this.page_admins,
                });
            }
        }
    }
</script>
