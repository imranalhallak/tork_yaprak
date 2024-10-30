<script setup>
import { ref, onMounted, watch } from 'vue';
import { usePage, Link } from '@inertiajs/vue3'; // Ensure this is imported

const props = usePage().props;
defineProps({


})
const goToCategory = (id) => {

    route('category', {  category: id })
};
// Define the menu items array as a reactive reference
const menuItems = ref(props.branch.data.categories || []); // Ensure it's a reactive reference
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

// Watch for changes in the branch's categories and update menuItems accordingly
watch(() => props.branch.data.categories, (newCategories) => {
    menuItems.value = newCategories; // Update menuItems
    animateMenuItems(); // Re-run animation when categories change
}, { immediate: true }); // This ensures that it updates on initial mount as well

// Automatically animate items when the component is mounted
onMounted(() => {
    animateMenuItems(); // Animate items on initial mount
});
</script>


<template>
    <div >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

        <div class="text-center mb-10">
            <div class="logo text-6xl mb-2 mt-10">

            </div>

            <!-- Centered div with width 500px -->
            <div class="centered-div" style="width:100vw;">
                <ul>
                    <li>
                        <div class="col">
                            <Link v-for="(item, index) in menuItems" :key="index"
                                :class="['w-full h-auto   menu-item2', { 'enter': enteredItems.includes(index) }]"
                                :href="route('branch.category', { branch: props.branch.data.id, category: item.id })"
                                :style="{ transitionDuration: (0.3 + index * 0.2) + 's' }">
                            {{ item.arabic_name }}
                            </Link>
                        </div>
                    </li>
                </ul>
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

.menu-list {
    list-style-type: none;
    /* Remove default list styles */
    padding: 0;
    /* Remove default padding */
}

.menu-item2 {
    position: relative;
    width: 80%;
    display: inline-table;
    /* Make the Link a block element */
    background-color: #ffffff;
    color: #a39268;
    font-weight: 700;
    padding: 20px;
    margin: 10px auto;
    /* Center horizontally */
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    transform: translateX(50%);
    /* Start off-screen (to the right) */
    opacity: 0;
    /* Hidden initially */
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.menu-item2.enter {
    transform: translateX(0);
    /* Bring it into view */
    opacity: 1;
    /* Make it visible */
}

/* Animation class when menu item enters */


/* Hover effect: scale up and change background color */
.menu-item2:hover {
    transform: scale(1.05);
    /* Slightly increase the size */
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    /* Increase shadow effect */
    background-color: #f0e5d6;
    /* Change background color on hover */
}

/* Center the div horizontally */
.centered-div {
    display: inline-flex;
    justify-content: center;
    /* Center the container content horizontally */
}
</style>
