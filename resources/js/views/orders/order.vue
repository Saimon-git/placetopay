<template>
    <div class="w-full h-12">
        <loading v-show="$apollo.loading" :center="true" :loading="true" :color="'#8BC63E'"></loading>
        <div v-show="!$apollo.loading" class="w-full h-12">
            <div class="w-full mb-4 bg-white">
                <h3 class="text-center mt-2 p-4">
                    Order Pay
                </h3>
            </div>
            <br>
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="send">
                <div class="mb-4 w-4/6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Poduct
                    </label>
                    <input type="text" v-model="create.product" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly="readonly">
                    <p class="text-red-400 mt-2" v-if="errors['input.product']">{{ errors['input.product'][0] }}</p>
                </div>
                <div class="mb-4 w-4/6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Total
                    </label>
                    <input type="number" v-model="order.total" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly="readonly">
                    <p class="text-red-400 mt-2" v-if="errors['input.total']">{{ errors['input.total'][0] }}</p>
                </div>
                <div class="mb-4 w-4/6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Phone
                    </label>
                    <input type="number" v-model="order.customer_mobile" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly="readonly">
                    <p class="text-red-400 mt-2" v-if="errors['input.phone']">{{ errors['input.phone'][0] }}</p>
                </div>

                <div class="flex items-center justify-between mt-5">
                    <button :disabled="sending" class="p-4 bg-green hover:bg-green text-white font-bold rounded focus:outline-none focus:shadow-outline" type="submit">
                        <span v-if="sending">Sending...</span>
                        <span v-else>Pay Order</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import mixin from "../../mixins";
    import ORDER from "../../graphql/orders/order.graphql";
    import PAY from "../../graphql/orders/pay.graphql";

    export default {
        name: "order",
        mixins: [mixin],

        components: {},

        data() {
            return {
                order: {},
                create:{
                    product: 'Producto 1'
                },
                errors: {},
                sending: false
            }
        },

        apollo: {
            getOrder: {
                query: ORDER,
                variables() {
                    return {
                        id: this.$route.params.id,
                    }
                },
                manual: true,
                result ({ data, loading, networkStatus }) {
                    this.order = data.order;
                }
            }
        },

        methods: {
            async send() {

                this.sending = true;

                await this.$apollo.mutate({
                    mutation: PAY,
                    variables: {
                        input: {
                            reference: this.order.reference,
                        }
                    }
                })
                    .then((data) => {
                        this.sending = false;
                        this.errors = {};
                        console.log(data.data);
                        window.location.replace(data.data.payOrder.processUrl);
                    })
                    .catch((error) => {
                        this.sending = false;

                        let { graphQLErrors } = error;

                        if (graphQLErrors[0].extensions.category === "validation") {
                            this.errors = graphQLErrors[0].extensions.validation;
                        }
                    });
            },
        }
    }
</script>
