
<template>
    <div class="container w-full mx-auto px-2">

        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">

                        <form>
                            <label for="default-search"
                                class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="search" v-model="searchTerm" @input="debounceSearchInput()"
                                    class="focus:ring-0 block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Search items by name..." required>
            
                            </div>
                        </form>

                        <table class="min-w-full text-left text-sm font-light">
                            <thead class="border-b bg-white font-medium">
                                <tr>
                                    <th scope="col" class="px-6 py-4">#</th>
                                    <th scope="col" class="px-6 py-4">Name</th>
                                    <th scope="col" class="px-6 py-4">Created</th>
                                    <th scope="col" class="px-6 py-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in filteredItems" class="border-b bg-neutral-100 transition duration-300 ease-in-out cursor-pointer hover:bg-pink-300">
                                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ item.id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ item.name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">{{ format(parseISO(item.created_at), 'LLL d, yyyy H:H') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <Link :href="`/orders/${item.id}`">
                                            <PrimaryButton>View</PrimaryButton>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>
<script>
import { defineComponent } from 'vue';
import _debounce from 'lodash/debounce'
import { router } from '@inertiajs/vue3'
import { format, parseISO } from 'date-fns'

export default defineComponent({
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            searchTerm: "",
            filteredItems: this.items,
            router: router
        }
    },
    created() {
        this.debounceSearchInput = _debounce(this.search, 500);
    },
    methods: {
        search() {
            if (this.searchTerm.trim().length === 0) {
                this.filteredItems = this.items
                return
            }
            this.filteredItems = this.items.filter(i => i.name.length && i.name.toLowerCase().indexOf(this.searchTerm.toLowerCase()) > -1)
        },
    },
})
</script>
