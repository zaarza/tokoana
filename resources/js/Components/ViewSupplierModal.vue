<script setup>
import Button from "@/Components/Button.vue";
import Input from "./Input.vue";

defineProps(["data"]);
defineEmits(["update:data"]);
</script>
<template>
    <Teleport to="#modals">
        <div class="overlay" v-if="data !== false">
            <div class="modal">
                <div class="modal__header">
                    <div class="modal__head-left">
                        <i class="iconoir-add-square modal__icon"></i>
                    </div>
                    <div class="modal__head-right">
                        <div class="modal__head-text">
                            <h1 class="modal__title">Supplier detail</h1>
                            <h2 class="modal__subtitle">Detail information about this supplier</h2>
                        </div>
                        <Button class="modal__close" :icon="'iconoir-cancel'" :variant="'secondary'" @click="$emit('update:data', false)" />
                    </div>
                </div>

                <div class="form">
                    <Input :displayName="'Supplier name'" :icon="'iconoir-user'" :type="'text'" :value="data.name" :disabled="true" />

                    <Input :displayName="'Phone number'" :icon="'iconoir-phone'" :type="'text'" :value="data.phone" :disabled="true" />

                    <Input :displayName="'Description'" :icon="'iconoir-notes'" :type="'text'" :value="data.description" :disabled="true" />

                    <div class="form__action">
                        <Button :text="'Close'" :variant="'secondary'" @click="$emit('update:data', false)" />
                    </div>
                </div>
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
