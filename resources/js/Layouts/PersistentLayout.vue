<script setup>
    import Navbar from '@/Components/Airentibarabino/Header.vue';
    import Footer from '@/Components/Airentibarabino/Footer.vue';
    import NavbarMobile from '@/Components/Airentibarabino/NavbarMobile.vue';
    import Search from '@/Components/Airentibarabino/Search.vue';
    import LangSwitcher from '@/Components/Airentibarabino/LanguageSwitcher.vue';
    import ScrollToTop from '@/Components/Airentibarabino/ScrollToTop.vue';
    import MainSlider from '@/Components/Airentibarabino/MainSlider.vue';
    import { Head, usePage } from '@inertiajs/vue3';
    import { onMounted, ref, watch } from 'vue';

    const showMainSlider = ref(true);

    // Check if we should show the main slider based on the current page
    const checkMainSlider = () => {
        const currentPath = window.location.pathname;
        // Hide main slider on blog pages and service detail pages
        showMainSlider.value = !currentPath.includes('/news-insights') && 
                              !currentPath.includes('/service/') &&
                              currentPath !== '/contact' &&
                              currentPath !== '/about' &&
                              currentPath !== '/mission_and_values';
    };

    onMounted(() => {
        checkMainSlider();
        
        const accordions = document.querySelectorAll(".accrodion-grp .accrodion");

        accordions.forEach(acc => {
            const title = acc.querySelector(".accrodion-title");
            if (title) {
                title.addEventListener("click", () => {
                    const isActive = acc.classList.contains("active");
                    const group = acc.parentElement.querySelectorAll(".accrodion");

                    group.forEach(a => {
                        a.classList.remove("active");
                        const content = a.querySelector(".accrodion-content");
                        if (content) {
                            content.style.display = "none";
                        }
                    });

                    if (!isActive) {
                        acc.classList.add("active");
                        const content = acc.querySelector(".accrodion-content");
                        if (content) {
                            content.style.display = "block";
                        }
                    }
                });
            }
        });
    });

    // Watch for route changes to update main slider visibility
    const page = usePage();
    watch(() => page.url, () => {
        checkMainSlider();
    });
</script>

<template>
    <Head title="Airentibarabino" />
    <div class="preloader">
        <img class="preloader__image" width="60" src="/images/loader.gif" alt="" />
    </div>
    <div class="page-wrapper">
        <Navbar />
        
        <MainSlider v-if="showMainSlider" />
        
        <slot />

        <Footer />
    </div>

    <NavbarMobile />
    <Search />
    <ScrollToTop />
    <LangSwitcher />
</template>
