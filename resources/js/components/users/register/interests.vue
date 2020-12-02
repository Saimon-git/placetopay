<template>
    <div>
        <div class="w-full p-6">
            <div class="mb-4 w-full mr-4">
                <input
                    @keyup.enter="addInterests"
                    placeholder="Press enter to add Interest"
                    v-model="create.interests"
                    type="text"
                    class="login-form-input block w-full focus:outline-none focus:shadow-outline"
                    autofocus>

                <p class="leading-normal text-normal text-justify mt-2">
                    Workouts (yoga, powerlifting).. Nutrition (diets, topics)..
                    Best Self (motivation, finance)
                </p>
            </div>

            <ul class="list-inside sm:list-outside md:list-inside lg:list-outside xl:list-inside">
                <li class="text-white bg-yellow-500 text-center p-2 mb-1"
                    v-for="(interest,key) in interests" :key="key">
                    {{ interest }}
                </li>
            </ul>

            <p v-if="errors.length > 0" class="text-red-500 text-xs italic">{{ errors[0] }}</p>

            <div class="flex flex-wrap -mx-2 mb-4 mt-4">
                <div class="w-full">
                    <button type="button" @click="finish" class="mt-4 btn bg-orange text-white w-full">
                        Finish
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
    import { ErrorBag } from 'vee-validate';

    export default {
        data() {
            return {
                interests: [],
                create: {},
                errors: []
            }
        },

        methods: {
            addInterests() {
                this.interests.push(this.create.interests);

                this.create = {};
                this.errors = [];
            },

            async finish() {
                if(this.interests.length > 0) {
                    await this.next();
                }
                else {
                    const errors = new ErrorBag();

                    errors.add({
                        field: 'interests',
                        msg: 'The Interests is required'
                    });

                    this.errors.push(errors.first('interests'));
                }
            },

            async next() {
                await this.$emit('next', {interests: this.interests}, 4);
            }
        }
    }
</script>