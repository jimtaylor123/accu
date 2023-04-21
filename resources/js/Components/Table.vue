
<template>
    <div class="container w-full md:w-4/5 xl:w-3/5  mx-auto px-2">


        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                    <div class="overflow-hidden">

                        <form>   
                            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <input type="search" id="default-search" class="focus:ring-0 block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search orders by name..." required>
                                <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                            </div>
                        </form>

                        <table class="min-w-full text-left text-sm font-light">
                            <thead class="border-b bg-white font-medium dark:border-neutral-500 dark:bg-neutral-600">
                                <tr>
                                    <th scope="col" class="px-6 py-4">#</th>
                                    <th scope="col" class="px-6 py-4">Name</th>
                                    <th scope="col" class="px-6 py-4">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <Link v-for="order in orders" :href="`orders/${order.id}`"> -->
                                    <tr v-for="order in orders" @click="" class="border-b bg-neutral-100 transition duration-300 ease-in-out cursor-pointer hover:bg-pink-300 dark:border-neutral-500 dark:bg-neutral-700">
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{ order.id }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ order.name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">{{ order.created_at }}</td>
                                    </tr>
                                <!-- </Link> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

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
})
</script>
