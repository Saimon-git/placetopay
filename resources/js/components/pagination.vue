<template>
    <div class="flex mt-10" v-if="pagination">
        <div class="w-1/2" v-if="total > 0">
            Show {{ pagination.firstItem }} to {{ total }} from {{ pagination.total }}
        </div>

        <div class="w-1/2" v-if="pagination.lastPage > 1">
            <ul class="flex float-right" v-if="pagination.lastPage > 1">
                <li class="mr-6" v-if="currentPage > 1">
                    <a @click.prevent="previous" :class="{'cursor-not-allowed': currentPage === 1}"
                       class="text-blue-500 hover:text-blue-800" href="#">Previous</a>
                </li>
                <li class="mr-6" v-for="page in pagination.lastPage">
                    <a @click.prevent="currentPage = page" class="text-blue-500 hover:text-blue-800" href="#">{{ page }}</a>
                </li>
                <li class="mr-6" v-if="currentPage < pagination.lastPage">
                    <a @click.prevent="next" :class="{'cursor-not-allowed': currentPage === pagination.lastPage}"
                       class="text-blue-500 hover:text-blue-800" href="#">Next</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                currentPage: 1,
                pages: [1],
            }
        },

        props: ['pagination'],

        watch: {
            currentPage() {
                this.$emit('update', this.currentPage)
            }
        },

        computed: {
            total() {
                let total = this.pagination ? this.pagination.count - 1 : 0;

                return this.pagination ? this.pagination.firstItem + total : 0;
            }
        },

        methods: {
            previous() {
                this.currentPage--;
                this.$emit('update', this.currentPage);
            },

            next() {
                this.currentPage++;
                this.$emit('update', this.currentPage);
            }
        }
    }
</script>