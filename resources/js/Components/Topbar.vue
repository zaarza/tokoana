<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted } from "vue";

const toggleSidebar = () => {
    document.querySelector(".sidebar").classList.toggle("sidebar--active");
};

const show = ref(false);
const main = ref(null);
const menu = ref(null);

let handler = event => {
    if (event.target === main.value) {
        show.value = !show.value;
    } else {
        show.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", handler);
});

onUnmounted(() => {
    document.removeEventListener("click", handler);
});
</script>

<template>
    <div class="topbar">
        <button class="topbar__toggle" @click="toggleSidebar">
            <i class="iconoir-menu"></i>
        </button>
        <button class="logged" ref="main">
            <div class="avatar">
                <i class="iconoir-user avatar__icon"></i>
            </div>
            <span class="logged__name">{{ $page.props.user.name }}</span>
            <i class="iconoir-nav-arrow-down logged__arrow"></i>
            <div class="logged__menu" :class="{ 'logged__menu--active': show }" ref="menu">
                <Link class="logged__link" as="a" href="/logout">Logout</Link>
            </div>
        </button>
    </div>
</template>

<style lang="scss" scoped>
.topbar {
    position: sticky;
    top: 0;
    padding: 1.5rem;
    min-width: 100%;
    border-bottom: 1px solid var(--color-4);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: var(--color-5);
    z-index: 99;

    &__toggle {
        all: unset;
        cursor: pointer;
        width: 44px;
        height: 44px;
    }
}

.logged {
    all: unset;
    cursor: pointer;
    display: flex;
    align-items: center;
    column-gap: 1rem;
    position: relative;

    &__name {
        pointer-events: none;
    }

    &__arrow {
        pointer-events: none;
    }

    &__menu {
        background-color: white;
        border-radius: 4px;
        border: 1px solid var(--color-4);
        position: absolute;
        right: 0;
        top: 100%;
        display: none;

        &--active {
            display: block;
        }
    }

    &__link {
        text-align: center;
        padding: 1rem 2rem;
        width: 100%;
        display: block;
        color: var(--color-1);
        text-decoration: none;
    }
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: var(--color-4);
    display: flex;
    justify-content: center;
    align-items: center;
    pointer-events: none;

    &__icon {
        color: var(--color-3);
    }
}
</style>
