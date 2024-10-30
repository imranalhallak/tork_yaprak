<script setup>
import InputError from "@/Components/InputError.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
// import axios from "axios";
import { watch, ref } from "vue";

defineProps({
    categories: {
        type: Object,
        required: true,
    },
});

let sections = ref({});

const form = useForm({
  price: '12',
  code: "",
  category_id: "",
  image: null,
  notebook_size: "",
  type_of_spiral:"",
  cover_type: "",
  paper_weight: "",
  number_of_pages: "",
  notebook_ruling: ""
});

const handleFileChange = (event) => {
  const file = event.target.files[0];
  form.image = file; // This binds the file to the form's image field
};

// watch(
//     () => form.class_id,
//     (newValue) => {
//         getSections(newValue);
//     }
// );

// const getSections = (classId) => {
//     axios.get("/api/sections?class_id=" + classId).then((response) => {
//         sections.value = response.data;
//     });
// };

const createProduct = () => {
    console.log(form);
  form.post(route("products.store"));
};
</script>

<template>
  <Head title="Create Product" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Product</h2>
    </template>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">

          <form @submit.prevent="createProduct">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                  <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Product Information
                  </h3>
                  <p class="mt-1 text-sm text-gray-500">
                    Use this form to create a new product.
                  </p>
                </div>

                <div class="grid grid-cols-6 gap-6">

                  <div class="col-span-6 sm:col-span-3">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select
                      v-model="form.category_id"
                      id="category_id"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.category_id,
                      }"
                    >
                      <option disabled value="">Select a category</option>
                      <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                      </option>
                    </select>
                    <InputError :message="form.errors.arabic_description" class="mt-2" />

                  </div>
                  <div class="col-span-6 sm:col-span-3">
                    <label for="notebook_size" class="block text-sm font-medium text-gray-700">Notebook Size</label>
                    <input
                      v-model="form.notebook_size"
                      type="text"
                      id="notebook_size"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.notebook_size,
                      }"
                    />
                    <InputError :message="form.errors.notebook_size" class="mt-2" />
                  </div>
                  <div class="col-span-6 sm:col-span-3">
                    <label for="type_of_spiral" class="block text-sm font-medium text-gray-700">Type of Spiral</label>
                    <input
                      v-model="form.type_of_spiral"
                      type="text"
                      id="type_of_spiral"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.type_of_spiral,
                      }"
                    />
                    <InputError :message="form.errors.type_of_spiral" class="mt-2" />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label for="cover_type" class="block text-sm font-medium text-gray-700">Cover Type</label>
                    <input
                      v-model="form.cover_type"
                      type="text"
                      id="cover_type"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.cover_type,
                      }"
                    />
                    <InputError :message="form.errors.cover_type" class="mt-2" />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label for="paper_weight" class="block text-sm font-medium text-gray-700">Paper Weight</label>
                    <input
                      v-model="form.paper_weight"
                      type="text"
                      id="paper_weight"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.paper_weight,
                      }"
                    />
                    <InputError :message="form.errors.paper_weight" class="mt-2" />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label for="number_of_pages" class="block text-sm font-medium text-gray-700">Number of Pages</label>
                    <input
                      v-model="form.number_of_pages"
                      type="text"
                      id="number_of_pages"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.number_of_pages,
                      }"
                    />
                    <InputError :message="form.errors.number_of_pages" class="mt-2" />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label for="notebook_ruling" class="block text-sm font-medium text-gray-700">Notebook Ruling</label>
                    <input
                      v-model="form.notebook_ruling"
                      type="text"
                      id="notebook_ruling"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.notebook_ruling,
                      }"
                    />
                    <InputError :message="form.errors.notebook_ruling" class="mt-2" />
                  </div>


                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="code"
                      class="block text-sm font-medium text-gray-700"
                      >Code</label
                    >
                    <input
                      v-model="form.code"

                      type="text"
                      id="code"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                          form.errors.code,
                      }"

                    />
                    <InputError :message="form.errors.code" class="mt-2" />
                  </div>

                    <div>
                        <label for="image">Image</label>
                        <input type="file" multiple @change="handleFileChange" />
                        <span v-if="form.errors.image">{{ form.errors.image }}</span>
                    </div>
                    </div>
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a
                  href="#"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4"
                >
                  Cancel
                </a>
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
