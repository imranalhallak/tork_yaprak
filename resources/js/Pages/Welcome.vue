<script setup>
import { ref, onMounted, watch } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import LangSwitcher from "@/Components/LangSwitcher.vue";
import Logo from "@/Components/Logo.vue";

const { t } = useI18n();
const props = usePage().props;
const { locale } = useI18n();
// Reactive variable to track the selected language
const language = ref('en'); // Default language

// Load saved language from local storage on mount
onMounted(() => {
    const savedLanguage = localStorage.getItem('language') || 'en';
    language.value = savedLanguage;
    console.log(savedLanguage);
    console.log(locale);
    document.documentElement.setAttribute('dir', savedLanguage === 'ar' ? 'rtl' : 'ltr');
});

// Watch for language changes and update direction accordingly
watch(language, (newLang) => {
    localStorage.setItem('language', newLang); // Save to local storage
    document.documentElement.setAttribute('dir', newLang === 'ar' ? 'rtl' : 'ltr');
});
// const svgList = [
//     <svg width="48" height="48" fill="none" aria-hidden="true" class="mb-6 text-pink-500 dark:text-pink-400"><path d="M5 11a4 4 0 0 1 4-4h30a4 4 0 0 1 4 4v26a4 4 0 0 1-4 4H9a4 4 0 0 1-4-4V11Z" fill="currentColor" fill-opacity=".1" stroke="currentColor" stroke-width="2"></path><path d="M15 7v34" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path></svg>,
//     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#a39268" class="m-auto bi bi-journal" viewBox="0 0 16 16">
//         <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
//         <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
//     </svg>
// ]
const goToCategory = (id) => {
    route('category', { category: id });
};

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
        <LangSwitcher style="position: fixed; direction: rtl; text-align: right;" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <div class="m-auto">
            <Logo class="w-52 m-auto" />
        </div>



        <div class="text-center mb-10">


            <div class="centered-div" style="width:100vw;">
                <div class="col col-md-6 ">
                    <Link v-for="(item, index) in menuItems" :key="index"
                    :class="['w-full h-auto menu-item2', { 'enter': enteredItems.includes(index) }]"
                    :href="route('category', { category: item.id })"
                    :style="{ transitionDuration: (0.3 + index * 0.2) + 's' }">
                  <div style="display: flex; align-items: center; justify-content: space-between; padding: 0 16px;">
                      <!-- SVG Icon Aligned to Start -->
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#a39268" class="bi bi-journal" viewBox="0 0 16 16">
                          <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2"/>
                          <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z"/>
                      </svg>

                      <!-- Centered Item Name -->
                      <span style="flex: 1; text-align: center;">{{ $t(item.name) }}</span>
                  </div>
              </Link>

                </div>
            </div>

            <div v-if="locale === 'ar'" class="container">
                <h1>تورك يابراك</h1>
                <p>تورك يابراك هي شركة متخصصة في إنتاج المنتجات الورقية والدفاتر بمختلف أنواعها، وتعتبر الشركة من
                    الشركات الرائدة في هذا المجال، وذلك بفضل التزامها بتقديم منتجات عالية الجودة تلبي احتياجات السوق
                    المحلية والدولية.</p>

                <h2>منتجات:</h2>
                <p>تتخصص شركة <span class="highlight">TORK YAPRAK</span> في إنتاج مجموعة واسعة من المنتجات الورقية، بما
                    في ذلك:</p>
                <ul>
                    <li>دفاتر مدرسية بأحجام وتصاميم مختلفة.</li>
                    <li>دفاتر احترافية تلبي احتياجات الشركات والأفراد.</li>
                    <li>أوراق طباعة وكتابة عالية الجودة مناسبة لجميع أنواع الطابعات.</li>
                    <li>منتجات ورقية أخرى مثل المخططات وأوراق الرسم وغيرها.</li>
                </ul>

                <h2>الجودة والابتكار:</h2>
                <p>تؤكد الشركة على استخدام أفضل المواد الخام وأحدث التقنيات في عمليات التصنيع لضمان منتجات متينة تتميز
                    بجودتها وطول عمرها. كما تلتزم شركة تورك يابراك بالابتكار المستمر في تصميماتها لتلبية الاحتياجات
                    المتنوعة لعملائها.</p>

                <h2>الاستدامة:</h2>
                <p>تشكل الاستدامة جوهر عمليات شركة <span class="highlight">TORK YAPRAK</span>، مع الالتزام بالممارسات
                    المسؤولة بيئيًا في كل مرحلة من مراحل الإنتاج، من اختيار المواد الخام إلى إدارة النفايات.</p>

                <h2>السوق والموقع:</h2>
                <p>تتمتع الشركة بحضور قوي في الأسواق المحلية والدولية، مع مستوى عالٍ من القدرة التنافسية مما يجعلها
                    الخيار المفضل للمدارس والشركات والمستهلكين الأفراد على حد سواء.</p>

                <p>باختصار، تعتبر شركة <span class="highlight">TORK YAPRAK</span> شريكًا موثوقًا به لأولئك الذين يبحثون
                    عن حلول ورقية مبتكرة وعالية الجودة، مدعومة بخبرة واسعة وفهم عميق لاحتياجات السوق.</p>

                <h2>لدينا 25 عامًا من الخبرة في هذا المجال</h2>
                <p>بدأت قصتنا في فلسطين حيث بدأنا رحلتنا في مجال صناعة الورق قبل 25 عاماً، وفي إطار سعينا لتوسيع أعمالنا
                    عالمياً، أسسنا شركتنا في تركيا حيث استمرت رحلتنا نحو التطور والازدهار.</p>

                <div class="footer">
                    © 2024 TORK YAPRAK - جميع الحقوق محفوظة
                </div>
            </div>

            <div v-if="locale === 'tr'" class="container">
                <h1>TORK YAPRAK</h1>
                <p>TORK YAPRAK, çeşitli tiplerde kağıt ürünleri ve defterlerin üretiminde uzmanlaşmış bir şirkettir.
                    Şirket, hem yerel hem de uluslararası pazarların ihtiyaçlarını karşılayan yüksek kaliteli ürünler
                    sunma taahhüdü sayesinde bu alanda lider kuruluşlardan biri olarak kabul edilmektedir.</p>

                <h2>Ürünler:</h2>
                <p>TORK YAPRAK, aşağıdakiler de dahil olmak üzere geniş bir yelpazede kağıt ürünleri üretme konusunda
                    uzmanlaşmıştır:</p>
                <ul>
                    <li>Çeşitli ebat ve tasarımlarda okul defterleri.</li>
                    <li>İşletmelerin ve bireylerin ihtiyaçlarına yönelik profesyonel defterler.</li>
                    <li>Her türlü yazıcıya uygun, yüksek kaliteli baskı ve yazım kağıtları.</li>
                    <li>Planlayıcılar, eskiz kağıtları ve daha fazlası gibi diğer kağıt ürünleri.</li>
                </ul>

                <h2>Kalite ve Yenilik:</h2>
                <p>Şirket, kaliteleri ve uzun ömürleriyle öne çıkan dayanıklı ürünler sağlamak için üretim süreçlerinde
                    en iyi hammaddelerin ve en son teknolojilerin kullanımına vurgu yapmaktadır. TORK YAPRAK ayrıca
                    müşterilerinin çeşitli ihtiyaçlarını karşılamak için tasarımlarında sürekli yeniliğe kendini
                    adamıştır.</p>

                <h2>Sürdürülebilirlik:</h2>
                <p>TORK YAPRAK'ın faaliyetlerinin merkezinde sürdürülebilirlik yer almakta olup, hammadde seçiminden
                    atık yönetimine kadar üretimin her aşamasında çevreye duyarlı uygulamalara bağlı kalınmaktadır.</p>

                <h2>Pazar ve Konum:</h2>
                <p>Şirket, yerel ve uluslararası pazarlarda güçlü bir varlığa sahip olup, yüksek rekabet gücü sayesinde
                    okullar, işletmeler ve bireysel tüketiciler için tercih edilen bir seçenektir.</p>

                <p>Özetle, TORK YAPRAK, pazar ihtiyaçlarına yönelik derin bir anlayış ve kapsamlı deneyimle desteklenen,
                    yenilikçi ve yüksek kaliteli kağıt çözümleri arayanlar için güvenilir bir ortaktır.</p>

                <h2>Alanında 25 Yıllık Deneyimimiz Var</h2>
                <p>Hikayemiz, 25 yıl önce kağıt sektöründeki yolculuğumuza başladığımız Filistin'de başlıyor.
                    İşletmemizi küresel olarak genişletme çabamız kapsamında, şirketimizi Türkiye'de kurduk ve burada
                    kalkınma ve refaha doğru yolculuğumuza devam ettik.</p>

                <div class="footer">
                    © 2024 TORK YAPRAK - Tüm hakları saklıdır
                </div>
            </div>

            <div v-if="locale === 'en'" class="container">
                <h1>TORK YAPRAK</h1>
                <p>TORK YAPRAK is a specialized company in the production of paper products and notebooks of various
                    types. The company is recognized as one of the leading entities in this field, thanks to its
                    commitment to delivering high-quality products that meet the needs of both local and international
                    markets.</p>

                <h2>Products:</h2>
                <p>TORK YAPRAK specializes in producing a wide range of paper products, including:</p>
                <ul>
                    <li>School notebooks in various sizes and designs.</li>
                    <li>Professional notebooks catering to the needs of businesses and individuals.</li>
                    <li>High-quality printing and writing papers suitable for all types of printers.</li>
                    <li>Other paper products such as planners, sketch papers, and more.</li>
                </ul>

                <h2>Quality and Innovation:</h2>
                <p>The company emphasizes the use of the best raw materials and the latest technologies in manufacturing
                    processes to ensure durable products that stand out for their quality and longevity. TORK YAPRAK is
                    also committed to continuous innovation in its designs to meet the diverse needs of its customers.
                </p>

                <h2>Sustainability:</h2>
                <p>Sustainability is at the core of TORK YAPRAK's operations, with a commitment to environmentally
                    responsible practices at every stage of production, from selecting raw materials to waste
                    management.</p>

                <h2>Market and Position:</h2>
                <p>The company holds a strong presence in both local and international markets, with a high level of
                    competitiveness that makes it a preferred choice for schools, businesses, and individual consumers
                    alike.</p>

                <p>In summary, TORK YAPRAK is a trusted partner for those seeking innovative and high-quality paper
                    solutions, backed by extensive experience and a deep understanding of market needs.</p>

                <h2>We Have 25 Years of Experience in the Field</h2>
                <p>Our story begins in Palestine, where we started our journey in the paper field 25 years ago. In our
                    endeavor to expand our business globally, we established our company in Turkey, where our journey
                    towards development and prosperity continued.</p>

                <div class="footer">
                    © 2024 TORK YAPRAK - All rights reserved
                </div>
            </div>

        </div>
    </div>
</template>

<style>
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f8f8;
}

.rtl {
    direction: rtl;
    text-align: right;
}

.ltr {
    direction: ltr;
    text-align: left;
}

.logo {
    color: #333;
}

.menu-item2 {
    display: block;
    padding: 10px 20px;
    margin: 10px 0;
    background-color: #e7e7e7;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.menu-item2:hover {
    background-color: #d5d5d5;
}

.footer {
    margin-top: 20px;
    font-size: 0.9rem;
    color: #666;
}

.highlight {
    color: #FF6347;
    /* Highlight color */
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f8f8;
}

.rtl {
    direction: rtl;
    text-align: right;
}

.ltr {
    direction: ltr;
    text-align: left;
}

.logo {
    color: #a39268;
}

.menu-list {
    list-style-type: none;
    padding: 0;
}

.menu-item2 {
    position: relative;
    width: 80%;
    display: inline-table;
    background-color: #ffffff;
    color: #a39268;
    font-weight: 700;
    padding: 20px;
    margin: 10px auto;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    transform: translateX(50%);
    opacity: 0;
    transition: transform 0.3s ease, opacity 0.3s ease;
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

.centered-div {
    display: inline-flex;
    justify-content: center;
}

.container {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    background-color: #FFF8DC;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    color: #A0522D;
    text-align: center;
    font-size: 2em;
}

h2 {
    color: #8B4513;
    font-size: 1.5em;
    margin-top: 20px;
}

p,
ul {
    font-size: 1em;
    margin-top: 15px;
}

ul {
    list-style-type: none;
    padding: 0;
}

ul li::before {
    content: "•";
    color: #8B4513;
    padding-right: 8px;
}

.highlight {
    color: #D2691E;
    font-weight: bold;
}

.footer {
    text-align: center;
    font-size: 0.9em;
    color: #5E3610;
    margin-top: 30px;
}
</style>
