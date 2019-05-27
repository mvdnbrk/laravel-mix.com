<template>
    <button type="button" @click.prevent="isOpen = ! isOpen" class="lg:hidden text-gray-500 focus:text-gray-500 focus:outline-none">
        <svg v-show="! isOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current w-6">
            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
        </svg>
        <svg v-show="isOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current w-6">
            <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
        </svg>
    </button>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false,
        }
    },
    watch: {
        isOpen() {
            document.getElementById('nav').classList.toggle('hidden');
            document.getElementById('content').classList.toggle('fixed');
        }
    }
}
</script>
