<template>
    <div class="dropdown inline-block relative">
        <button class="font-semibold py-2 px-4 rounded inline-flex items-center">
            <slot name="title"></slot>
        </button>
        <ul class="dropdown-menu absolute hidden bg-white pt-1 rounded-lg shadow-2xl bg-white-50%">
            <slot name="list"></slot>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "DropDown"
    }
</script>