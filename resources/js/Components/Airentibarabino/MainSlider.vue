<script setup>

import { Link } from '@inertiajs/vue3';
import { useLanguage } from '../../Composables/useLanguage.js'

const { getTranslatedText } = useLanguage();

// Slider content with translations
const sliderContent = {
    heroTitle: {
        it: "Airenti & Barabino <br /> Dottori Commercialisti",
        en: "Airenti & Barabino <br /> Chartered Accountants",
        fr: "Airenti & Barabino <br /> Experts-Comptables"
    },
    discoverMore: {
        it: "Scopri di più",
        en: "Discover More",
        fr: "Découvrir plus"
    }
};

</script>

<template>
    <section class="main-slider">
        <div
        class="swiper-container thm-swiper__slider"
        data-swiper-options='{"slidesPerView": 1, "loop": true,
    "effect": "fade",
    "pagination": {
        "el": "#main-slider-pagination",
        "type": "bullets",
        "clickable": true
    },
    "navigation": {
        "nextEl": "#main-slider__swiper-button-next",
        "prevEl": "#main-slider__swiper-button-prev"
    },
    "autoplay": {
        "delay": 5000
    }}'
        >
        <div class="swiper-wrapper">
            <div class="swiper-slide">
            <div class="video-background">
                <!-- <video autoplay muted loop playsinline>
                <source
                    src="/images/backgrounds/4382-178617337.mp4"
                    type="video/mp4"
                />
                </video> -->
            </div>
            <div
                class="image-layer"
                style="
                background-image: url(/images/contact/Torino-AB_To_DSC1473.jpeg);
                "
            ></div>
            <!-- /.video-background -->
            <!-- <div class="main-slider__social">
                <a href="#">facebook</a>
                <a href="#">twitter</a>
                <a href="#">instagram</a>
            </div> -->
            <div class="container">
                <div class="row">
                <div class="col-lg-12">
                    <div class="main-slider__content">
                    <div class="main-slider__title-box-1">
                        <h2 v-html="getTranslatedText(sliderContent.heroTitle)">
                        </h2>
                        <!-- <div class="main-slider__title-box-2">
                        <h2>
                            Airenti & Barabino <br />
                            Dottori Commercialisti
                        </h2>
                        </div> -->
                    </div>
                    <Link
                        :href="route('about')"
                        class="thm-btn"
                        >{{ getTranslatedText(sliderContent.discoverMore) }}</Link
                    >
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="swiper-slide">
            <div class="video-background">
                <!-- <video autoplay muted loop playsinline>
                <source
                    src="/images/backgrounds/4382-178617337.mp4"
                    type="video/mp4"
                />
                </video> -->
            </div>
            <!-- /.video-background -->
            <div
                class="image-layer"
                style="
                background-image: url(/images/contact/Genova_DSC0952Bs.png);
                "
            ></div>
            <!-- /.image-layer -->
            <!-- <div class="main-slider__social">
                <a href="#">facebook</a>
                <a href="#">twitter</a>
                <a href="#">instagram</a>
            </div> -->
            <div class="container">
                <div class="row">
                <div class="col-lg-12">
                    <div class="main-slider__content">
                    <div class="main-slider__title-box-1">
                        <h2 v-html="getTranslatedText(sliderContent.heroTitle)">
                        </h2>
                        <div class="main-slider__title-box-2">
                        <!-- <h2>
                            Your <br />
                            Hero Text <br />
                            Here
                        </h2> -->
                        </div>
                    </div>
                    <Link
                        :href="route('about')"
                        class="thm-btn"
                        >{{ getTranslatedText(sliderContent.discoverMore) }}</Link
                    >
                    <!-- <div class="main-slider-badge">
                        <img
                        data-tilt
                        src="/images/resources/main-slider-badge.png"
                        alt=""
                        />
                    </div> -->
                    </div>
                </div>
                </div>
            </div>
            </div>

            <div class="swiper-slide">
            <div class="video-background">
                <!-- <video autoplay muted loop playsinline>
                <source
                    src="/images/backgrounds/4382-178617337.mp4"
                    type="video/mp4"
                />
                </video> -->
            </div>
            <div
                class="image-layer"
                style="
                background-image: url(/images/contact/Genova_DSC0952B.jpeg);
                "
            ></div>
            <!-- /.video-background -->
            <!-- <div class="main-slider__social">
                <a href="#">facebook</a>
                <a href="#">twitter</a>
                <a href="#">instagram</a>
            </div> -->
            <div class="container">
                <div class="row">
                <div class="col-lg-12">
                    <div class="main-slider__content">
                    <div class="main-slider__title-box-1">
                        <h2 v-html="getTranslatedText(sliderContent.heroTitle)">
                        </h2>
                        <div class="main-slider__title-box-2">
                        <!-- <h2>
                            Your <br />
                            Hero Text <br />
                            Here
                        </h2> -->
                        </div>
                    </div>
                    <Link
                        :href="route('about')"
                        class="thm-btn"
                        >{{ getTranslatedText(sliderContent.discoverMore) }}</Link
                    >
                    <!-- <div class="main-slider-badge">
                        <img
                        data-tilt
                        src="/images/resources/main-slider-badge.png"
                        alt=""
                        />
                    </div> -->
                    </div>
                </div>
                </div>
            </div>
            </div>

            <div class="swiper-slide">
            <div class="video-background">
                <!-- <video autoplay muted loop playsinline>
                            <source
                                src="/images/backgrounds/4382-178617337.mp4"
                                type="video/mp4"
                            />
                            </video> -->
            </div>
            <div
                class="image-layer"
                style="
                background-image: url(/images/contact/Genova_DSC0952B.png);
                "
            ></div>
            <!-- /.video-background -->
            <!-- <div class="main-slider__social">
                <a href="#">facebook</a>
                <a href="#">twitter</a>
                <a href="#">instagram</a>
            </div> -->
            <div class="container">
                <div class="row">
                <div class="col-lg-12">
                    <div class="main-slider__content">
                    <div class="main-slider__title-box-1">
                        <h2 v-html="getTranslatedText(sliderContent.heroTitle)">
                        </h2>
                        <div class="main-slider__title-box-2">
                        <!-- <h2>
                                        Your <br />
                                        Hero Text <br />
                                        Here
                                    </h2> -->
                        </div>
                    </div>
                    <Link
                        :href="route('about')"
                        class="thm-btn"
                        >{{ getTranslatedText(sliderContent.discoverMore) }}</Link
                    >
                    <!-- <div class="main-slider-badge">
                                    <img
                                    data-tilt
                                    src="/images/resources/main-slider-badge.png"
                                    alt=""
                                    />
                                </div> -->
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- If we need navigation buttons -->
        <div class="slider-bottom-box clearfix">
            <div class="swiper-pagination" id="main-slider-pagination"></div>
            <div class="main-slider__nav">
            <div
                class="swiper-button-prev"
                id="main-slider__swiper-button-prev"
            >
                <span class="icon-arrow-left"></span>
            </div>
            <div
                class="swiper-button-next"
                id="main-slider__swiper-button-next"
            >
                <span class="icon-arrow-right"></span>
            </div>
            </div>
        </div>
        </div>
    </section>
</template>
