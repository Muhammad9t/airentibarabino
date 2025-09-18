<script setup>
    import Navbar from '@/Components/Airentibarabino/Header.vue';
    import Footer from '@/Components/Airentibarabino/Footer.vue';
    import NavbarMobile from '@/Components/Airentibarabino/NavbarMobile.vue';
    import Search from '@/Components/Airentibarabino/Search.vue';
    import LangSwitcher from '@/Components/Airentibarabino/LanguageSwitcher.vue';
    import ScrollToTop from '@/Components/Airentibarabino/ScrollToTop.vue';
    import MainSlider from '@/Components/Airentibarabino/MainSlider.vue';
    import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Airentibarabino" />
    <div class="preloader">
        <img class="preloader__image" width="60" src="/images/loader.gif" alt="" />
    </div>
    <div class="page-wrapper">
      <Navbar />

        <MainSlider />
        <slot />

      <Footer />
    </div>

    <NavbarMobile />

    <Search />

    <ScrollToTop />

    <LangSwitcher />
</template>

