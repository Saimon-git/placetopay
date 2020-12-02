<template>
    <div>
        <div class="w-full p-6">
            <div class="mb-4 w-full mr-4">
                <v-select
                        v-validate="'required'"
                        name="country"
                        label="value"
                        :options="countries"
                        class="w-full"
                        v-model="create.country"
                        @input="loadStates"
                        placeholder="Country">
                </v-select>

                <p class="text-red-500 text-xs italic mt-4">{{ vErrors.first('country') }}</p>
            </div>

            <div class="mb-4 w-full mr-4">
                <v-select
                        v-validate="'required'"
                        name="state"
                        label="value"
                        :options="states"
                        class="w-full"
                        v-model="create.state"
                        placeholder="State">
                </v-select>

                <p class="text-red-500 text-xs italic mt-4">{{ vErrors.first('state') }}</p>
            </div>

            <div class="mb-4 w-full mr-4">
                <input
                        v-validate="'required'"
                        name="city"
                        placeholder="City"
                        v-model="create.city"
                        type="text"
                        class="login-form-input block w-full focus:outline-none focus:shadow-outline"
                        autofocus>

                <p class="text-red-500 text-xs italic mt-4">{{ vErrors.first('city') }}</p>
            </div>

            <div class="flex flex-wrap -mx-2 mb-4">
                <div class="w-full">
                    <button
                        type="button"
                        @click="updateLocation"
                        class="btn bg-orange text-white w-full">
                        <span v-if="registering">Saving...</span>
                        <span v-else>Next</span>
                    </button>

                    <button
                        type="button"
                        @click="next"
                        class="w-full text-orange text-center mt-2">
                        Skip this step
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import COUNTRIES from "../../../graphql/core/countries.graphql";
    import STATES from "../../../graphql/core/states.graphql";

    import vSelect from 'vue-select';

    export default {
        components: {vSelect},

        data() {
            return {
                countries: [],
                states: [],
                create: {},
                registering: false
            }
        },

        apollo: {
            getCountries: {
                query: COUNTRIES,
                manual: true,
                result ({ data, loading, networkStatus }) {
                    data.countries.data.forEach(element => {
                        this.countries.push({label: element.id, value: element.name});
                    });
                }
            }
        },

        methods: {
            async loadStates(element){
                const response = await this.$apollo.query({
                    query: STATES,
                    variables: {
                        country_id: element.label,
                        first: 100,
                    }
                });

                this.states = [];
                response.data.states.data.forEach(element => {
                    this.states.push({label: element.id, value: element.name});
                })
            },

            async updateLocation() {
                await this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.next();
                    }
                });
            },

            async next() {
                await this.$emit('next', this.create, 3);
            }
        }
    }
</script>