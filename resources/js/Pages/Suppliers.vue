<script>
import { router } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import Search from "@/Components/Search.vue";
import Button from "@/Components/Button.vue";
import AddNewSupplierModal from "../Components/AddNewSupplierModal.vue";
import ViewSupplierModal from "../Components/ViewSupplierModal.vue";
import axios from "axios";

export default {
    layout: MainLayout,
    components: {
        Search,
        Button,
        AddNewSupplierModal,
        ViewSupplierModal,
    },
    data() {
        return {
            modal: {
                addNewSupplierModal: false,
                viewSupplierModal: {
                    show: false,
                    id: null,
                    data: {},
                },
            },
        };
    },
    methods: {
        toggleItemAction(event) {
            Array.from(
                document.getElementsByClassName("item-action__list--active")
            ).forEach((element) => {
                if (event.target.nextElementSibling != element) {
                    element.classList.toggle("item-action__list--active");
                }
            });

            event.target.nextElementSibling.classList.toggle(
                "item-action__list--active"
            );
        },
        removeItem(event, id) {
            event.target.parentElement.parentElement.children[1].checked = false;
            router.delete(`/suppliers/${id}`);
        },
        blur(event) {
            if (
                event.relatedTarget === null ||
                !event.relatedTarget.className.includes("item-action__link")
            ) {
                event.target.checked = false;
            }
        },
    },
    watch: {
        "modal.viewSupplierModal.id": async function () {
            if (this.modal.viewSupplierModal.id !== null) {
                const { data } = await axios.get(
                    `/suppliers/${this.modal.viewSupplierModal.id}`
                );
                this.modal.viewSupplierModal.data = data;
                this.modal.viewSupplierModal.show = true;
            } else {
                this.modal.viewSupplierModal.show = false;
            }
        },
    },
};
</script>

<template>
    <MainLayout>
        <div class="content">
            <div class="content__row content__row--between">
                <h1 class="content__title">Suppliers</h1>
                <Search />
            </div>
            <div class="actions">
                <div class="actions__left">
                    <Button
                        :text="'Sort by'"
                        :icon="'iconoir-sort'"
                        :variant="'secondary'"
                    />
                    <Button
                        :text="'Filter'"
                        :icon="'iconoir-filter'"
                        :variant="'secondary'"
                    />
                    <Button
                        :text="'Remove selected (1)'"
                        :icon="'iconoir-cancel'"
                        :variant="'secondary'"
                    />
                </div>
                <div class="actions__right">
                    <Button
                        :text="'Add new supplier'"
                        :icon="'iconoir-plus'"
                        :variant="'primary'"
                        @click="this.modal.addNewSupplierModal = true"
                    />
                </div>
            </div>
            <table class="table">
                <thead class="table__head table__row">
                    <th class="table__cell">
                        <input type="checkbox" name="" id="" />
                    </th>
                    <th class="table__cell">NAME</th>
                    <th class="table__cell">PHONE</th>
                    <th class="table__cell">DESCRIPTION</th>
                    <th class="table__cell">ACTIONS</th>
                </thead>

                <tbody class="table__body">
                    <tr class="table__row" v-for="item in $page.props.data">
                        <td class="table__cell" :key="item.id">
                            <input type="checkbox" name="" id="" />
                        </td>
                        <td class="table__cell">{{ item.name }}</td>
                        <td class="table__cell">{{ item.phone }}</td>
                        <td class="table__cell">{{ item.description }}</td>
                        <td class="table__cell">
                            <div class="item-action">
                                <Button :icon="'iconoir-nav-arrow-down'" />
                                <input
                                    type="checkbox"
                                    class="item-action__checkbox"
                                    @blur="blur"
                                />
                                <div class="item-action__list">
                                    <Button
                                        :text="'View'"
                                        :variant="'clear'"
                                        class="item-action__link"
                                        @click="
                                            this.modal.viewSupplierModal.id =
                                                item.id
                                        "
                                    />
                                    <Button
                                        :text="'Edit'"
                                        :variant="'clear'"
                                        class="item-action__link"
                                    />
                                    <Button
                                        :text="'Remove'"
                                        :variant="'clear'"
                                        class="item-action__link"
                                        @click="
                                            (event) =>
                                                removeItem(event, item.id)
                                        "
                                    />
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </MainLayout>
    <AddNewSupplierModal
        :show="this.modal.addNewSupplierModal"
        @close="this.modal.addNewSupplierModal = false"
    />
    <ViewSupplierModal
        :show="this.modal.viewSupplierModal.show"
        :data="this.modal.viewSupplierModal.data"
        @close="this.modal.viewSupplierModal.id = null"
    />
</template>

<style lang="scss" scoped>
@use "./../../css/app";
.content {
    display: flex;
    flex-direction: column;
    row-gap: 1rem;

    &__row {
        display: flex;

        &--between {
            justify-content: space-between;
        }
    }

    &__title {
        font-size: 1.5rem;
        font-weight: 500;
        color: var(--color-1);
    }
}
.table {
    @include app.table;
}

.actions {
    display: flex;
    justify-content: space-between;
    align-items: center;

    &__left {
        display: flex;
        column-gap: 1rem;
    }
}

.item-action {
    display: flex;
    position: relative;
    width: fit-content;

    &__checkbox {
        all: unset;
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
    }

    &__checkbox:checked {
        ~ .item-action__list {
            display: flex;
        }
    }

    &__list {
        border-radius: 4px;
        position: absolute;
        display: none;
        top: calc(100% + 1rem);
        right: 0;
        background-color: var(--color-5);
        z-index: 9;
        border: 1px solid var(--color-4);
        flex-direction: column;

        &--active {
            display: flex;
        }
    }
}
</style>