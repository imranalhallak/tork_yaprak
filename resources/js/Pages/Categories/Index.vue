<script setup>
import MagnifyingGlass from "@/Components/Icons/MagnifyingGlass.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link, Head, useForm, router, usePage } from "@inertiajs/vue3";
import { ref, computed, watch, onMounted } from "vue";

const props = defineProps({
  categories: {
    type: Object,
    required: true,
  },
});

// const categoriesList = ref([...props.categories]); // Use spread operator to create a reactive copy of categories

const page = usePage();

let search = ref(usePage().props.search),
  class_id = ref(usePage().props.class_id ?? ""),
  pageNumber = ref(1);

let studentsUrl = computed(() => {
  let url = new URL(route("categories.index"));
  url.searchParams.append("page", pageNumber.value);

  if (search.value) {
    url.searchParams.append("search", search.value);
  }

  if (class_id.value) {
    url.searchParams.append("class_id", class_id.value);
  }

  return url;
});

const updatedPageNumber = (link) => {
  pageNumber.value = link.url.split("=")[1];
};

watch(
  () => studentsUrl.value,
  (updatedStudentsUrl) => {
    router.visit(updatedStudentsUrl, {
      preserveScroll: true,
      preserveState: true,
      replace: true,
    });
  }
);
const categoriesList = ref([]);
onMounted(() => (categoriesList.value = props.categories.data));
const items = ref([
  { id: 1, name: "Item 1" },
  { id: 2, name: "Item 2" },
  { id: 3, name: "Item 3" },
]);
watch(
  () => search.value,
  (value) => {
    console.log(categories.value);
    if (value) {
      pageNumber.value = 1;
      value === null ? (value = "") : "";
    }
  }
);
const onEnd = (link) => {
  pageNumber.value = link.url.split("=")[1];
};
const deletForm = useForm({});

const deleteCategory = (studentId) => {
  if (confirm("Are you sure you want to delete this student?")) {
    deletForm.delete(route("categories.destroy", studentId));
  }
};
const cleanImageUrl = (image) => {
  // Remove '/admin' from the image path
  return image.replace("/admin", "");
};
const getImagePath = (image) => {
  // Modify the path to remove '/storage' and use 'meal_images' instead
  return image.replace("/storage", "");
};
</script>

<template>
  <Head title="Categories List" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories List</h2>
    </template>
    <div class="bg-gray-100 py-10">
      <div class="mx-auto max-w-7xl">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="text-xl font-semibold text-gray-900">Categories</h1>
              <p class="mt-2 text-sm text-gray-700">A list of all the Categories.</p>
            </div>

            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
              <Link
                :href="route('categories.create')"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
              >
                Add Category
              </Link>
            </div>
          </div>

          <div class="flex flex-col justify-start sm:flex-row mt-6">
            <div class="relative text-sm text-gray-800 col-span-3">
              <div
                class="absolute pl-2 left-0 top-0 bottom-0 flex items-center pointer-events-none text-gray-500"
              >
                <MagnifyingGlass />
              </div>

              <input
                v-model="search"
                type="text"
                autocomplete="off"
                placeholder="Search categories data..."
                id="search"
                class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
              />
            </div>
            <!-- <select
                            v-model="class_id"
                            class="block rounded-lg border-0 py-2 ml-5 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 sm:text-sm sm:leading-6"
                        >
                            <option value="">Filter By Class</option>
                            <option
                                :value="item.id"
                                :key="item.id"
                                v-for="item in classes.data"
                            >
                                {{ item.name }}
                            </option>
                        </select> -->
          </div>
          <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="block">
                  <h1>Draggable Categories Table</h1>
                  <table class="table-auto w-full">
                    <thead>
                      <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                      </tr>
                    </thead>

                    <!-- Draggable tbody with itemKey -->

                    <!-- Slot for each item -->

                    <tr
                      v-for="category in categories.data"
                      :key="category.id"
                      class="cursor-move handle"
                    >
                      <draggable
                        :list="categories.data"
                        class="list-group"
                        ghost-class="ghost"
                        v-model="categoriesList"
                      >
                        <template #item>
                          <td class="border px-4 py-2">{{ "category.id" }}</td>
                          <td class="border px-4 py-2">{{ "category.name" }}</td>
                        </template>
                        <!-- <td class="border px-4 py-2">
                            <img
                              :src="getImageUrl(category.image)"
                              alt="Image"
                              class="w-16 h-16"
                            />
                          </td> -->
                      </draggable>
                    </tr>
                  </table>
                </div>

                <div
                  class="overflow- shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative "
                >
                  <table class="min-w-full divide-y divide-gray-300 ">
                    <thead class="bg-gray-50">
                      <tr>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        >
                          ID
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        >
                          Name
                        </th>


                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Created At
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6" />
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      <tr v-for="category in categories.data" :key="category.id">
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                        >
                          {{ category.id }}
                        </td>
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                        >
                          <p>{{ category.name }}</p>
                        </td>


                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {{ category.created_at }}
                        </td>

                        <td
                          class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                        >
                          <Link
                            :href="route('categories.edit', category.id)"
                            class="text-indigo-600 hover:text-indigo-900"
                          >
                            Edit
                          </Link>
                          <button
                            @click="deleteCategory(category.id)"
                            class="ml-2 text-indigo-600 hover:text-indigo-900"
                          >
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <Pagination :data="categories" :updatedPageNumber="updatedPageNumber" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
