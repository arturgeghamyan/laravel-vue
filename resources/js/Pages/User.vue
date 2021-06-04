<template>
    <loader v-if="loader"></loader>

    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        {{ data.name }} {{ data.surname }}
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>


</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
import Loader from '@/Components/Loader'
import axios from 'axios'

export default {
    components: {
        Loader,
        BreezeAuthenticatedLayout,
    },

    data() {
        return {
            data: [],
            loader: true
        }
    },

    mounted() {
        axios.get('/user')
            .then(res => {
                    this.data = res.data
                    this.loader = false
            })
    },

    props: {
        auth: Object,
        errors: Object,
    },
}
</script>
