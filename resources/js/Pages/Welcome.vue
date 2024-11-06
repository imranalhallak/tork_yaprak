<script setup>
// Imports
import { ref, onMounted, watch, getCurrentInstance } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import ToggleLight from "@/Components/ToggleLight.vue";
import Logo from "@/Components/Logo.vue";

// Language and translation
const { t } = useI18n();
const props = usePage().props;

// Reactive variable for language selection
const language = ref('en');

// Get global language setting
const { appContext } = getCurrentInstance();
const globalLanguage = appContext.config.globalProperties.$globalLanguage;

// Set page direction based on language selection
const setDirection = (lang) => {
    document.documentElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
};
const showImage = ref(false);

// Load saved language and set direction on mount
onMounted(() => {
    setDirection(globalLanguage.selectedLanguage);
    // Set a timeout to display the image after 2 seconds
    setTimeout(() => {
        showImage.value = true;
    }, 2000);
});

// Watch for language changes to update page direction
watch(
    () => globalLanguage.selectedLanguage,
    (newLanguage) => {
        setDirection(newLanguage);
    }
);

// Menu items and animations
const menuItems = ref(props.$categories.data.categories);
const enteredItems = ref([]);

const animateMenuItems = () => {
    enteredItems.value = [];
    menuItems.value.forEach((item, index) => {
        setTimeout(() => {
            enteredItems.value.push(index);
        }, index * 50);
    });
};

// Update menu items and animate them immediately
watch(() => props.$categories.data, (newCategories) => {
    menuItems.value = newCategories;
    animateMenuItems();
}, { immediate: true });

onMounted(() => {
    animateMenuItems();
});
</script>

<template>
    <div>
        <!-- Toggle Light Mode Button -->
        <ToggleLight style="position: fixed; direction: rtl; text-align: right;" />

        <!-- Load External Fonts and Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

        <!-- Logo Component -->
        <div class="">
            <Logo class="w-52 m-auto my-container  " />
        </div>

        <!-- Main Content and Menu Items -->
        <div class="text-center mb-10">
            <div class="centered-div" style="width:100vw;">
                <div class="col col-md-6 ">
                    <Link
                        v-for="(item, index) in menuItems"
                        :key="index"
                        :class="['w-full h-auto menu-item2', { 'enter': enteredItems.includes(index) }]"
                        :href="route('category', { category: item.id })"
                        :style="{ transitionDuration: (0.3 + index * 0.2) + 's' }"
                    >
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0 16px;">
                            <!-- SVG Icon with Color -->
                            <img :src="item.svg" class="svg-icon" />

                            <!-- Centered Item Name -->
                            <span style="flex: 1; text-align: center;">{{ $t(item.name) }}</span>
                        </div>
                    </Link>
                    <!-- Additional Links -->
                    <Link :href="route('about')">
                        <div class="container w-40 menu-item " style="
                        font-size: 20px;">{{$t('About Us')}}</div>
                    </Link>

                    <!-- Embedded Video -->
                    <div class="video-container">
                        <div class="responsive-video-container">
                            <iframe
                                src="https://www.youtube.com/embed/Vcoq8YNTB4s?si=ykZr9Pt-JLvPis2C"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                    <div class="social-media-icons">
                        <a href="https://www.torkyaprak.com/" target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-globe"></i>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61564511385301&mibextid=ZbWKwL" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/905061572633" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Global Styles */
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f8f8;
}
/* Existing styles remain the same */

/* Centered video styling */
.video-container {
    display: flex;

    justify-content: center;
    margin-top: 20px;
}

.centered-video {
    border-radius: 8px; /* Optional for rounded corners */
}
/* SVG Icon Style */
.svg-icon {
    color: #A0522D;
}

/* Main Content Styling */
.menu-item2 {
    position: relative;
    width: 80%;
    display: inline-table;
    background-color: #ffffff;
    color: #a39268;
    font-weight: 700;
    font-size: 20px;
    padding: 20px;
    margin: 10px auto;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    transform: translateX(50%);
    opacity: 0;
    transition: transform 0.3s ease, opacity 0.3s ease;
}
.my-container{
    position: relative;
    color: #a39268;
    font-weight: 700;
    padding: 20px;
    margin: 10px auto;
    border-radius: 10px;
    box-shadow: 0 0px 0px 0 rgba(0, 0, 0, 0.1);
    text-align: center;
}
.menu-item2.enter {
    transform: translateX(0);
    opacity: 1;
}

.menu-item2:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    background-color: #f0e5d6;
}

/* Centering Container */
.centered-div {
    display: inline-flex;
    justify-content: center;
}

/* Container Styling */
.container {
    color: #a39268;
    font-weight: 700;
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    background-color: #FFF8DC;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1, h2 {
    color: #A0522D;
    text-align: center;
}

ul li::before {
    content: "•";
    color: #8B4513;
    padding-right: 8px;
}

.footer {
    text-align: center;
    font-size: 0.9em;
    color: #5E3610;
    margin-top: 30px;
}
.logo-container {
    margin: 20px auto;
    display: flex;
    justify-content: center;
}
.video-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* Responsive video container */
.responsive-video-container {
    position: relative;
    width: 100%;
    max-width: 800px; /* Limit the width */
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
}

.responsive-video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}
.styled-logo {
    position: relative;
    width: 80%;
    max-width: 300px; /* Ensure it doesn't get too large */
    background-color: #ffffff;
    color: #a39268;
    font-weight: 700;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow only at top and bottom */
    text-align: center;
}
    @keyframes slideUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
/* Social Media Icons Styling */
.social-media-icons {
    position: fixed;
    top: 50%; /* Center vertically */
    left: 0; /* Stick to the left */
    transform: translateY(-50% 0); /* Adjust for vertical centering */
    display: flex;
    flex-direction: column;
    gap: 15px; /* Space between icons */
    padding: 10px;
    background-color: rgba(255, 255, 255, 0.7); /* Optional background for better visibility */
    border-radius: 0 8px 8px 0; /* Rounded corners on the right */
    animation: slideUp 1.5s ease-out; /* Apply the animation */



}

.social-media-icons a {
    margin: 0 10px;
    color: #a39268; /* Default color for icons */
    font-size: 24px;
    text-decoration: none;
}

.social-media-icons a:hover {
    color: #7e6c3e; /* Change color on hover */
}
</style>
