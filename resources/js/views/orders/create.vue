<template>
    <div class="w-full h-12">
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
                <input type="number" v-model="create.total" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-red-400 mt-2" v-if="errors['input.total']">{{ errors['input.total'][0] }}</p>
            </div>
            <div class="mb-4 w-4/6">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Phone
                </label>
                <input type="number" v-model="create.phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <p class="text-red-400 mt-2" v-if="errors['input.phone']">{{ errors['input.phone'][0] }}</p>
            </div>

            <div class="flex items-center justify-between mt-5">
                <button :disabled="sending" class="p-4 bg-green hover:bg-green text-white font-bold rounded focus:outline-none focus:shadow-outline" type="submit">
                    <span v-if="sending">Sending...</span>
                    <span v-else>Create Order</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import mixin from "../../mixins";
import SEND from '../../graphql/orders/create.graphql'
export default {
    name: "create",

    mixins: [mixin],

    data() {
        return {
            create: {
                total: Math.floor((Math.random() * 100) + 1),
                product: 'Product 1'
            },
            errors: {},
            sending: false
        }
    },

    methods: {
        async send() {

            this.sending = true;

            await this.$apollo.mutate({
                mutation: SEND,
                variables: {
                    input: {
                        total: this.create.total,
                        phone: this.create.phone
                    }
                }
            })
                .then((data) => {
                    this.sending = false;
                    this.errors = {};
                    return this.$router.push('/orders/'+data.data.createOrder.id);
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

<style scoped>

</style>
