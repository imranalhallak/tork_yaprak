<script setup>
import InputError from '@/Components/InputError.vue';

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue"; // Import 'ref' to handle reactivity
import { watch } from "vue";
const form = useForm({
  name: "",
  logo: null,
  slogan: "",
});
const props = defineProps({

});
const createBranch = () => {
  console.log(form);
};
const handleImageUpload = (event) => {
  const file = event.target.files[0];
  form.logo = file; // This binds the file to the form's image field
};
const submitBranch = (branch_id) => {
  // Submit the selected branch ID to the specified route
  form.branch_id = branch_id;
  form.post(route("set-branch"));
};
const darkMode = ref(false); // Use 'true' or any logic to toggle based on system/user preference
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout >
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
    </template>



    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
          <form @submit.prevent="createBranch">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                  <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Create Branch
                  </h3>
                  <p class="mt-1 text-sm text-gray-500">
                    Use this form to create a new branch.
                  </p>
                </div>

                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 sm:col-span-3">
                    <label for="name" class="block text-sm font-medium text-gray-700"
                      >Name</label
                    >
                    <input
                      v-model="form.name"
                      type="text"
                      id="name"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                          form.errors.name,
                      }"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                  </div>
                  <div class="col-span-6 sm:col-span-3">
                    <label for="slogan" class="block text-sm font-medium text-gray-700"
                      >Slogan</label
                    >
                    <input
                      v-model="form.slogan"
                      type="text"
                      id="slogan"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                          form.errors.slogan,
                      }"
                    />
                    <InputError :message="form.errors.slogan" class="mt-2" />
                  </div>

                  <div>
                    <label for="logo">Logo</label>
                    <input type="file" @change="handleImageUpload" id="logo" />
                    <span v-if="form.errors.logo">{{ form.errors.logo }}</span>
                  </div>

                </div>
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">

                <button
                  type="submit"
                  class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  Create
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
