<template>
    <div class="flex w-full p-4">
        <div class="w-5/6">
            <div class="w-full mb-4 bg-white">
                <h3 class="text-center mt-2 p-4">
                    Orders List
                </h3>
            </div>
            <div class="w-full mb-4 bg-white p-4">
                <div>

                    <br>

                    <div class="w-full">
                        <div class="mb-4" id="active" >
                            <loading v-show="$apollo.loading" :center="true" :loading="true" :color="'#8BC63E'"></loading>
                            <list-orders v-show="!$apollo.loading" :values="orders" @reload="reload"></list-orders>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-1/6 bg-white-400">
            <router-link to="/orders/create" class="w-full inline-block bg-green text-white text-center p-4 rounded ml-3 mt-2">
                <svg class="fill-current inline-block text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path class="heroicon-ui" d="M17 11a1 1 0 0 1 0 2h-4v4a1 1 0 0 1-2 0v-4H7a1 1 0 0 1 0-2h4V7a1 1 0 0 1 2 0v4h4z"/>
                </svg>
                Create Order
            </router-link>
        </div>
    </div>
</template>

<script>
    import ListOrders from "./../../components/orders/tblorders";

    import MANAGEMENT from "../../graphql/orders/management.graphql";

    export default {
        name: "orders",

        components: {ListOrders},

        data() {
            return {
                active: 1,
                orders: {},
                page_orders: 1,
                update: false
            }
        },

        apollo: {
            getData: {
                query: MANAGEMENT,
                variables() {
                    return {
                        page_order: this.page_orders,
                    }
                },
                manual: true,
                result ({ data, loading, networkStatus }) {
                    this.orders = data.orders;
                }
            }
        },

        methods: {
            async reload(query) {
                await this.$apollo.queries.getData.refetch({
                    page_orders: query.page_orders ? query.page_orders : this.page_orders,
                });
            }
        }
    }
</script>
