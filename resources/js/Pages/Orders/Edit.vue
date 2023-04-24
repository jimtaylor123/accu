<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Order</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <header>
                        <h2 class="text-lg font-medium text-gray-900">Order Information</h2>
                    </header>

                    <p class="mt-3 text-sm text-gray-600">
                        <span class="font-bold">Customer: </span> {{ order.customer.name }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600">
                        <span class="font-bold">Total weight: </span> {{ order.weight }} kg
                    </p>
                    <p class="mt-1 text-sm text-gray-600">
                        <span class="font-bold">Last updated: </span> {{ format(parseISO(order.updated_at), 'LLL d, yyyy H:H') }}
                    </p>
                    <br/>

                    <hr>

                    <UpdateOrderNameForm :order="order" class="max-w-xl" />
                </div>
            </div>
        </div>
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-8 bg-white">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Order Items</h2>
                        </header>
                    </div>
                    <OrderItemsTable :items="orderItems" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateOrderNameForm from './UpdateOrderNameForm.vue';
import OrderItemsTable from './OrderItemsTable.vue';
import { Head } from '@inertiajs/vue3';
import { format, parseISO } from 'date-fns'
</script>
<script>
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        order: {
            type: Object,
            required: true
        },
        orderItems: {
            type: Array,
            required: true
        },
    },
    data() {
        return {

        }
    },
    mounted() {
        console.log('ORDER', this.order, 'ITEMS', this.orderItems)
    }
})
</script>