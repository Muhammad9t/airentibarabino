<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import '../../../css/admin.css';
const page =  usePage();
const totalServices = page.props.totalServices
const totalBlogs = page.props.totalBlogs
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-700">Total Services</h3>
                        <p class="text-3xl font-extrabold text-indigo-600 mt-2">
                            {{ totalServices }}
                        </p>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-700">Total Blogs</h3>
                        <p class="text-3xl font-extrabold text-green-600 mt-2">
                            {{ totalBlogs }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
