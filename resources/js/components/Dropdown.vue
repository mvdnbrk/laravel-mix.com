<template>
    <div class="dropdown relative">
        <div
            @click.prevent="isOpen = ! isOpen"
            aria-haspopup="true"
            :aria-expanded="isOpen"
        >
            <slot name="trigger"></slot>
        </div>

        <transition name="pop-out-quick">
            <ol
                class="absolute bg-gray-100 rounded mt-2 py-1 shadow z-30 right-0"
                v-show="isOpen"
                role="menu"
            >
                <slot></slot>
            </ol>
        </transition>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false
        };
    },

    watch: {
        isOpen(isOpen) {
            if (isOpen) {
                document.addEventListener("keydown", this.onEscape)
                document.addEventListener('click', this.onClickOutside);
            }
        }
    },

    methods: {
        dismiss() {
            this.isOpen = false;

            document.removeEventListener('click', this.onEscape);
            document.removeEventListener('click', this.onClickOutside);
        },
        onEscape(e) {
            if (e.key !== "Escape") {
                return;
            }

            this.dismiss();
        },
        onClickOutside(e) {
            if (e.target === this.$el || this.$el.contains(e.target)) {
                return;
            }

            this.dismiss();
        }
    }
}
</script>

<style>
.pop-out-quick-enter-active,
.pop-out-quick-leave-active {
    transition: all 0.4s;
}

.pop-out-quick-enter,
.pop-out-quick-leave-active {
    opacity: 0;
    transform: translateY(-7px);
}
</style>
