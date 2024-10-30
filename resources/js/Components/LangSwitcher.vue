<template>
    <div>
      <div class="language-selector">
        <select @change="changeLocale" v-model="locale">
          <option value="en">En</option>
          <option value="ar">ع</option>
          <option value="tr">Tr</option>
        </select>
      </div>

      <div class="text-center mb-10">
        <!-- Your existing content here -->
      </div>
      
    </div>
  </template>

  <script setup>
  import { useI18n } from 'vue-i18n';
  import { ref, onMounted, watch } from 'vue';
  import { defineEmits } from 'vue';

const emit = defineEmits(['change']);
  const { locale } = useI18n();

  // Check if a locale is already saved in localStorage on load
  onMounted(() => {
    const savedLocale = localStorage.getItem('locale');
    if (savedLocale) {
      locale.value = savedLocale;
    }
    // Set direction based on initial locale
    document.documentElement.setAttribute('dir', locale.value === 'ar' ? 'rtl' : 'ltr');
  });

  // Update locale and save it to localStorage when the user changes it
  const changeLocale = (event) => {
    locale.value = event.target.value;
    emit('change',event.target.value );
    localStorage.setItem('locale', locale.value);
  };

  // Watch for locale changes and update direction accordingly
  watch(locale, (newLocale) => {
    document.documentElement.setAttribute('dir', newLocale === 'ar' ? 'rtl' : 'ltr');
  });
  </script>

  <style scoped>
  .language-selector {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px;
  }

  select {
    padding: 10px;
    background-color: #a39268; /* SaddleBrown color */
    color: #FFF8DC; /* Cornsilk color for contrast */
    border: 1px solid #5E3610; /* Darker brown for border */
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    appearance: none; /* Removes the default arrow in most browsers */
  }

  select:focus {
    outline: none;
    border-color: #a39268; /* A bit lighter brown when focused */
    box-shadow: 0px 0px 5px #D2691E;
  }

  /* Your existing styles here */
  </style>
