<script setup>
import Button from "@/Components/Button.vue";
import Input from "./Input.vue";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

defineProps(["show"]);
defineEmits(["update:show"]);

const form = ref({
    name: "",
    phone: "",
    description: ""
});

const submit = close => {
    router.post("/suppliers", form.value, {
        onSuccess: () => {
            close();
            form.value = {
                name: "",
                phone: "",
                description: ""
            };
        }
    });
};
</script>
<template>
    <Teleport to="#modals">
        <div class="overlay" v-if="show">
            <div class="modal">
                <div class="modal__header">
                    <div class="modal__head-left">
                        <i class="iconoir-add-square modal__icon"></i>
                    </div>
                    <div class="modal__head-right">
                        <div class="modal__head-text">
                            <h1 class="modal__title">Add new supplier</h1>
                            <h2 class="modal__subtitle">Fill the data below to add new supplier</h2>
                        </div>
                        <Button class="modal__close" :icon="'iconoir-cancel'" :variant="'secondary'" @click="$emit('update:show', false)" />
                    </div>
                </div>

                <form class="form" @submit.prevent="submit(() => $emit('update:show', false))">
                    <Input
                        :name="'name'"
                        :displayName="'Supplier name'"
                        :icon="'iconoir-user'"
                        :type="'text'"
                        :placeholder="'Supplier name'"
                        :value="form.name"
                        @update="newValue => (form.name = newValue)"
                        :error="$page.props.errors.name"
                    />

                    <Input
                        :name="'phone'"
                        :displayName="'Phone number'"
                        :icon="'iconoir-phone'"
                        :type="'number'"
                        :placeholder="'Phone number'"
                        :value="form.phone"
                        @update="newValue => (form.phone = newValue)"
                        :error="$page.props.errors.phone"
                    />

                    <Input
                        :name="'description'"
                        :displayName="'Description'"
                        :icon="'iconoir-notes'"
                        :type="'text'"
                        :placeholder="'Description'"
                        :value="form.description"
                        @update="newValue => (form.description = newValue)"
                        :error="$page.props.errors.description"
                    />

                    <div class="form__action">
                        <Button :text="'Cancel'" :variant="'secondary'" @click="$emit('update:show', false)" />
                        <Button :text="'Add'" :variant="'primary'" :icon="'iconoir-plus'" :type="'submit'" />
                    </div>
                </form>
            </div>
        </div>
    </Teleport>
</template>

<style lang="scss" scoped>
.overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background-color: rgba($color: #000000, $alpha: 0.4);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal {
    background-color: var(--color-5);
    border-radius: 4px;
    border: 1px solid var(--color-3);
    height: fit-content;

    &__header {
        display: flex;
        column-gap: 1rem;
        padding: 1.5rem;
        border-bottom: 1px solid var(--color-4);
    }

    &__icon {
        font-size: 1.5rem;
        color: var(--color-1);
    }

    &__title {
        font-size: 1.2rem;
        color: var(--color-1);
    }

    &__subtitle {
        color: var(--color-3);
    }

    &__head-text {
        display: flex;
        flex-direction: column;
        row-gap: 0.5rem;
    }

    &__head-right {
        display: flex;
        column-gap: 3rem;
    }
}

.form {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    row-gap: 2rem;

    &__action {
        display: flex;
        justify-content: space-between;
    }
}
</style>
