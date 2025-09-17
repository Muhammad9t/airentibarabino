<script setup>
    import Navbar from '@/Components/Airentibarabino/Header.vue';
    import Footer from '@/Components/Airentibarabino/Footer.vue';
    import NavbarMobile from '@/Components/Airentibarabino/NavbarMobile.vue';
    import Search from '@/Components/Airentibarabino/Search.vue';
    import LangSwitcher from '@/Components/Airentibarabino/LanguageSwitcher.vue';
    import ScrollToTop from '@/Components/Airentibarabino/ScrollToTop.vue';
</script>

<template>
    <div class="preloader">
      <img
        class="preloader__image"
        width="60"
        src="/images/loader.gif"
        alt=""
      />
    </div>
    <div class="page-wrapper">
      <Navbar />

        <!-- body content -->

      <Footer />
    </div>

    <NavbarMobile />

    <Search />

    <ScrollToTop />

    <LangSwitcher />
</template>

<style scoped>
    .team-flip-card {
        background: transparent;
        width: 100%;
        height: 520px;
        perspective: 1200px;
        max-width: 400px;
        margin: 0 auto;
        display: inline-block;
    }
    .team-flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.7s cubic-bezier(0.4, 2.08, 0.55, 0.44);
        transform-style: preserve-3d;
    }
    .team-flip-card:hover .team-flip-card-inner,
    .team-flip-card:focus-within .team-flip-card-inner {
        transform: rotateY(180deg);
    }
    .team-flip-card-front,
    .team-flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .team-flip-card-front img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 20%;
    }
    .team-flip-card-back {
        background: #db3d32;
        color: #fff;
        transform: rotateY(180deg);
        padding: 2rem 1.5rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .team-flip-card-back h3 {
        font-size: 1.7rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #fff;
    }
    .team-flip-card-back p {
        font-size: 1rem;
        margin-bottom: 0.7rem;
    }
    .team-flip-card-back .linkedin-icon {
        margin-top: 1.2rem;
        color: #fff;
        font-size: 1.5rem;
        display: inline-block;
        transition: color 0.2s;
    }
    .team-flip-card-back .linkedin-icon:hover {
        color: #000;
    }
</style>
