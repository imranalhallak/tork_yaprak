<script setup>
import InputError from "@/Components/InputError.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, usePage, Link } from "@inertiajs/vue3";
import axios from "axios";
import { onMounted } from "vue";
import { watch, ref } from "vue"

const category = usePage().props.category;
console.log(category);
const form = useForm({
    name: category.name??null,
});
const handleImageUpload = (event) => {
      let file = event.target.files[0];
      console.log("file" + file);
      form.image = file; // This binds the file to the form's image field
};


const updateCategory = () => {
    console.log(form);

    form.post(route("categories.update", category.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Update Category" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update Category
            </h2>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">




                </div>
            </div>
        </div>
    </template>
    <form @submit.prevent="updateCategory">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Update Category
                    </h3>
                </div>

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700"
                            >Name</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            id="arabic_name"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            :class="{
                                'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                                    form.errors.name,
                            }"
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                </div>
            </div>

            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button
                    type="submit"
                    class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Update
                </button>
            </div>
        </div>
    </form>
    </AuthenticatedLayout>
</template>
