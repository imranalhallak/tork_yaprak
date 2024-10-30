<script setup>
import { ref, onMounted , watch, getCurrentInstance,} from 'vue';
import { usePage } from '@inertiajs/vue3';
import BackButton from "@/Components/BackButton.vue";
import { useI18n } from 'vue-i18n';

// Access the global language variable
const { appContext } = getCurrentInstance();
const globalLanguage = appContext.config.globalProperties.$globalLanguage;
const { t } = useI18n();
const props = usePage().props;
const { locale } = useI18n();
// Reactive variable to track the selected language
const language = ref('en'); // Default language

// Load saved language from local storage on mount
onMounted(() => {
    const { appContext } = getCurrentInstance();


    document.documentElement.setAttribute('dir', globalLanguage.selectedLanguage === 'ar' ? 'rtl' : 'ltr');
});

// Watch for language changes and update direction accordingly

defineProps({
    product: {
        type: Object
    }
});
const product = ref(props.product);
const productTitle = ref(null);
</script>

<template>

    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden mt-10">
        <div class="bg-white p-4 flex justify-between items-center">

            <span class="text-gray-700 font-semibold">
                {{ $t(product.category.name) }}
            </span>
        </div>
        <div class="relative">
            <img alt="Pistachio Cocoa Cream chocolates" class="w-full" height="200" :src="`../${product.image}`" width="400" />
        </div>
        <div class="p-4">
            <div class="bg-brown-700 text-white p-2 rounded-lg flex justify-between items-center animate-from-right" style="background-color: brown;">
                <span>{{$t('Code')}}: {{ product.code }}</span>
                <!-- <span>{{ product.price }} Piece/kg</span> -->
            </div>
            <div class="text-center mt-4">

                <!-- Additional Product Details -->
                <p v-if="product.type_of_spiral" class="text-gray-600 mt-2 animate-from-bottom">{{ $t('Typre of Spiral') }}: {{ $t(product.type_of_spiral) }}</p>
                <p v-if="product.notebook_size" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Notebook Size')}}: {{ $t(product.notebook_size) }}</p>
                <p v-if="product.cover_type" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Cover Type')}}: {{ $t(product.cover_type) }}</p>
                <p v-if="product.paper_weight" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Paper Weight')}}: {{ $t(product.paper_weight) }}</p>
                <p v-if="product.number_of_pages" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Number of Pages')}}: {{ $t(product.number_of_pages) }}</p>
                <p v-if="product.notebook_ruling" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Notebook Ruling')}}: {{ $t(product.notebook_ruling) }}</p>
            </div>
        </div>
        <div class="p-4 flex justify-end">
            <button class="bg-brown-700 text-white p-2 rounded-full">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>
    </div>
    <BackButton/>
</template>

<style scoped>
/* Animation and Styling */
.animate-from-bottom {
    position: relative;
    opacity: 0;
    transform: translateY(100%);
    animation: slideUp 0.5s ease-out forwards;
}

@keyframes slideUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-from-right {
    position: relative;
    opacity: 0;
    transform: translateX(100%);
    animation: slideLeft 0.5s ease-out forwards;
}

@keyframes slideLeft {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f8f8;
}

.max-w-md {
    font-family: 'Cairo', sans-serif;
}

.logo {
    color: #a39268;
}

/* Other styling remains unchanged */
</style>
