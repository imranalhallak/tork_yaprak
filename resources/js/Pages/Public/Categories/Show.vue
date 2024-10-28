
<script setup>
import { ref, onMounted, watch } from 'vue';
import { usePage,Link } from '@inertiajs/vue3'; // Ensure this is imported

const props = usePage().props;
// const goToCategory = (id) => {

// Define the menu items array as a reactive reference
const menuItems = ref(props.category.data.categories || []); // Ensure it's a reactive reference
// Define a reactive array to track which items have animated in
const enteredItems = ref([]);

// Function to animate the menu items
const animateMenuItems = () => {
    enteredItems.value = []; // Reset the entered items before animation
    menuItems.value.forEach((item, index) => {
        setTimeout(() => {
            enteredItems.value.push(index);
        }, index * 50); // Adjust the delay for each item as needed
    });
};

watch(() => props.category.data.products, (newProducts) => {
    menuItems.value = newProducts; // Update menuItems
    animateMenuItems(); // Re-run animation when categories change
}, { immediate: true }); // This ensures that it updates on initial mount as well

// Automatically animate items when the component is mounted
onMounted(() => {
    animateMenuItems(); // Animate items on initial mount
});
</script>



<template>
    <div>


  <title>
  </title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>

  <div class="container mx-auto p-4  max-w-lg  rounded-lg shadow-lg overflow-hidden mt-10 " style="  height: 100vh; /* Full height of the screen */
  ">
   <div class="flex justify-between items-center mb-4">
    <img alt="logo" class="h-12"
    :src="`../../logo.png`" style="height:  80px; "/>
    <h1 class="text-xl font-bold text-gray-700">
     {{props.category.data.arabic_name}}
    </h1>
   </div>
   <div class="grid grid-cols-2 gap-2"                 >
    <Link

    v-for="(item, index) in menuItems"
    :key="index"
    :href="route('category.product', { category:props.category.data.id, product:item.id})"

    class="bg-white p-4 rounded-lg shadow"
    :class="['menu-item1', { 'enter': enteredItems.includes(index) }]"
    :style="{
      transitionDuration: (index > 10 ? (0.3 + index * 0.2) : 0.3 ) + 's'
    }"
  >
    <img
      alt="item.english_name"
      class="w-full h-auto rounded-lg"
      height="200"
      :src="`../../${item.image}`"
      width="300"
    />
    <p class="mt-2 text-center text-gray-600">
      {{ item.code }}
    </p>
</Link>
   </div>
  </div>
</div>
</template>


<style>
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f8f8;
}

.logo {
    color: #a39268;
}

.menu-item1{
    background-color: #ffffff;
    color: #a39268;
    font-weight: 700;
    padding: 5px;
    margin: 5px 0;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    transform: translateX(50%); /* Start off-screen (to the right) */
    opacity: 0; /* Hidden initially */
    transition: transform 0.3s ease, opacity 0.3s ease;
    cursor: pointer; /* Change cursor on hover */
    transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s; /* For hover effects */
}

/* Animation class when menu item enters */
.menu-item1.enter {
    transform: translateX(0); /* Bring it into view */
    opacity: 1; /* Make it visible */
}

/* Hover effect: scale up and change background color */
.menu-item1:hover {
    transform: scale(1.05); /* Slightly increase the size */
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2); /* Increase shadow effect */
    background-color: #f0e5d6; /* Change background color on hover */
}

/* Center the div horizontally */
.centered-div {
    width: 500px;
    margin: 0 auto; /* This centers the div horizontally */
}
</style>

