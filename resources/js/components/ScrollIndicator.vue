<template>
    <div class="v-scroll--indicator-wrapper" :style="{ height, background }">
        <div class="v-scroll--indicator" :style="{ width, background: color }"></div>
    </div>
</template>

<script>
// Drop-in replacement for the Vue 2 only `vue-scroll-indicator` package.
export default {
    props: {
        height: {
            type: String,
            default: '5px',
        },
        color: {
            type: String,
            default: 'linear-gradient(to right, #ec008c, #fc6767)',
        },
        background: {
            type: String,
            default: '#eaeaea',
        },
    },

    data() {
        return {
            width: '0%',
        };
    },

    mounted() {
        window.addEventListener('load', this.update);
        window.addEventListener('scroll', this.update, { passive: true });
        this.update();
    },

    unmounted() {
        window.removeEventListener('load', this.update);
        window.removeEventListener('scroll', this.update);
    },

    methods: {
        update() {
            const scrolled = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;

            this.width = (height > 0 ? (scrolled / height) * 100 : 0) + '%';
        },
    },
};
</script>
