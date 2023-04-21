
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Table :orders="orders"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Table from '@/Components/Table.vue';
import { Head } from '@inertiajs/vue3';
</script>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        orders: {
            type: Array,
            required: true
        }
    },
    data() {
        return {

        }
    },
    mounted(){
        console.log('ORDERS', this.orders)
    }
})
</script>

