<script setup>
import InputError from "@/Components/InputError.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm , usePage} from "@inertiajs/vue3";
import { ref, watch } from "vue";


const product = usePage().props.product;
const categories = usePage().props.categories;

// Populate form with existing product data
const form = useForm({
    price: product.price || '12',
    code: product.code || "",
    category_id: product.category_id || "",
    images: [], // New images for upload
    notebook_size: product.notebook_size || "",
    type_of_spiral: product.type_of_spiral || "",
    cover_type: product.cover_type || "",
    paper_weight: product.paper_weight || "",
    number_of_pages: product.number_of_pages || "",
    notebook_ruling: product.notebook_ruling || ""
});

// Handle file input changes
const handleFileChange = (event) => {
    form.images = Array.from(event.target.files); // Store all selected files
};

// Update product
const updateProduct = () => {
    form.post(route("products.update", { id: product.id }));
};

// Dynamic input class based on error presence
const inputClass = (error) => {
    return {
        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': error,
        'border-gray-300': !error
    };
};

</script>

<template>
  <Head title="Edit Product" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Product</h2>
    </template>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
          <form @submit.prevent="updateProduct">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                  <h3 class="text-lg leading-6 font-medium text-gray-900">Product Information</h3>
                  <p class="mt-1 text-sm text-gray-500">Use this form to edit the product.</p>
                </div>

                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 sm:col-span-3">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select
                      v-model="form.category_id"
                      id="category_id"
                      class="mt-1 block w-full py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="inputClass(form.errors.category_id)"
                    >
                      <option disabled value="">Select a category</option>
                      <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                      </option>
                    </select>
                    <InputError :message="form.errors.category_id" class="mt-2" />
                  </div>

                  <div class="col-span-6 sm:col-span-3" v-for="(field, index) in [
                      { label: 'Notebook Size', model: 'notebook_size', id: 'notebook_size' },
                      { label: 'Type of Spiral', model: 'type_of_spiral', id: 'type_of_spiral' },
                      { label: 'Cover Type', model: 'cover_type', id: 'cover_type' },
                      { label: 'Paper Weight', model: 'paper_weight', id: 'paper_weight' },
                      { label: 'Number of Pages', model: 'number_of_pages', id: 'number_of_pages' },
                      { label: 'Notebook Ruling', model: 'notebook_ruling', id: 'notebook_ruling' },
                      { label: 'Code', model: 'code', id: 'code' }
                  ]" :key="index">
                    <label :for="field.id" class="block text-sm font-medium text-gray-700">{{ field.label }}</label>
                    <input
                      v-model="form[field.model]"
                      type="text"
                      :id="field.id"
                      class="mt-1 block w-full py-2 px-3 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="inputClass(form.errors[field.model])"
                    />
                    <InputError :message="form.errors[field.model]" class="mt-2" />
                  </div>

                  <div class="col-span-6 sm:col-span-3">
                    <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                    <input type="file" multiple @change="handleFileChange" />
                    <InputError :message="form.errors.images" class="mt-2" />
                  </div>
                </div>
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4">
                  Cancel
                </a>
                <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Update
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
