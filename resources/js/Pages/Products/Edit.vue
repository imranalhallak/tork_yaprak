<script setup>
import InputError from "@/Components/InputError.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

// Destructure props and get product and categories from the page props
defineProps({
  categories: {
    type: Object,
    required: true,
  },
});

const product = usePage().props.product;
const categories = usePage().props.categories;

// Initialize the form with product data if available
const form = useForm({
    arabic_name: product.arabic_name ?? null,
  english_name: product.english_name ?? null,
  turkish_name: product.turkish_name ?? null,
  arabic_description: product.arabic_description ?? null,
  turkish_description: product.turkish_description ?? null,
  english_description: product.english_description ?? null,
  price: product.price ?? null,
  code: product.code ?? "",
  category_id: product.category_id ?? "",
  image: null, // This will be updated by handleImageUpload
  // New fields
  notebook_size: product.notebook_size ?? null,
  cover_type: product.cover_type ?? null,
  paper_weight: product.paper_weight ?? null,
  number_of_pages: product.number_of_pages ?? null,
  notebook_ruling: product.notebook_ruling ?? null,

});

// Handle image file upload and bind to form
const handleImageUpload = (event) => {
  let file = event.target.files[0];
  form.image = file;
};

// Submit the form to update the product
const updateProduct = () => {
  form.post(route("products.update", product.id), {
    preserveScroll: true,
  });
};
</script>

<template>
  <Head title="Update Product" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update Product</h2>
    </template>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <form @submit.prevent="updateProduct">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Product Information</h3>
            <p class="mt-1 text-sm text-gray-500">Use this form to update the product.</p>

            <div class="grid grid-cols-6 gap-6">

              <!-- Category Selection -->
              <div class="col-span-6 sm:col-span-3">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select
                  v-model="form.category_id"
                  id="category_id"
                  class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3"
                  :class="{'border-red-300 text-red-900': form.errors.category_id}"
                >
                  <option disabled value="">Select a category</option>
                  <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.arabic_name }}
                  </option>
                </select>
                <InputError :message="form.errors.category_id" class="mt-2" />
              </div>


              <!-- Code -->
              <div class="col-span-6 sm:col-span-3">
                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                <input
                  v-model="form.code"
                  type="text"
                  id="code"
                  class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3"
                  :class="{'border-red-300 text-red-900': form.errors.code}"
                />
                <InputError :message="form.errors.code" class="mt-2" />
              </div>
              <div class="col-span-6 sm:col-span-3">
                <label for="notebook_size" class="block text-sm font-medium text-gray-700">Notebook Size</label>
                <input
                  v-model="form.notebook_size"
                  type="text"
                  id="notebook_size"
                  class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3"
                  :class="{'border-red-300 text-red-900': form.errors.notebook_size}"
                />
                <InputError :message="form.errors.notebook_size" class="mt-2" />
              </div>

              <!-- Cover Type -->
              <div class="col-span-6 sm:col-span-3">
                <label for="cover_type" class="block text-sm font-medium text-gray-700">Cover Type</label>
                <input
                  v-model="form.cover_type"
                  type="text"
                  id="cover_type"
                  class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3"
                  :class="{'border-red-300 text-red-900': form.errors.cover_type}"
                />
                <InputError :message="form.errors.cover_type" class="mt-2" />
              </div>

              <!-- Paper Weight -->
              <div class="col-span-6 sm:col-span-3">
                <label for="paper_weight" class="block text-sm font-medium text-gray-700">Paper Weight</label>
                <input
                  v-model="form.paper_weight"
                  type="text"
                  id="paper_weight"
                  class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3"
                  :class="{'border-red-300 text-red-900': form.errors.paper_weight}"
                />
                <InputError :message="form.errors.paper_weight" class="mt-2" />
              </div>

              <!-- Number of Pages -->
              <div class="col-span-6 sm:col-span-3">
                <label for="number_of_pages" class="block text-sm font-medium text-gray-700">Number of Pages</label>
                <input
                  v-model="form.number_of_pages"
                  type="text"
                  id="number_of_pages"
                  class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3"
                  :class="{'border-red-300 text-red-900': form.errors.number_of_pages}"
                />
                <InputError :message="form.errors.number_of_pages" class="mt-2" />
              </div>

              <!-- Notebook Ruling -->
              <div class="col-span-6 sm:col-span-3">
                <label for="notebook_ruling" class="block text-sm font-medium text-gray-700">Notebook Ruling</label>
                <input
                  v-model="form.notebook_ruling"
                  type="text"
                  id="notebook_ruling"
                  class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3"
                  :class="{'border-red-300 text-red-900': form.errors.notebook_ruling}"
                />
                <InputError :message="form.errors.notebook_ruling" class="mt-2" />
              </div>
              <!-- Image Upload -->
              <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" @change="handleImageUpload" id="image" />
                <span v-if="form.errors.image" class="text-red-500 text-sm">{{ form.errors.image }}</span>
              </div>
            </div>

          </div>

          <!-- Form Actions -->
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <a
              href="#"
              class="inline-flex items-center px-4 py-2 border rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
            >
              Cancel
            </a>
            <button
              type="submit"
              class="bg-indigo-600 rounded-md py-2 px-4 inline-flex justify-center text-white hover:bg-indigo-700"
            >
              Update
            </button>
          </div>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>
