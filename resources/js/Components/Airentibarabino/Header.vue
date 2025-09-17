<script setup>

import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue'


const page = usePage();

const componentName = computed(() => {
    const parts = page.component.split('/')
    console.log(parts[parts.length - 1]);
  return parts[parts.length - 1]
});

</script>

<template>
    <header class="main-header clearfix">
        <nav class="main-menu clearfix">
            <div class="main-menu-wrapper">
                <div class="main-menu-wrapper__logo">
                    <a :href="route('home')">

                    <img
                        src="/images/resources/logo-1.png"
                        style="width: 100px"
                        alt=""
                    />
                    </a>
                </div>
                <div class="main-menu-wrapper__main-menu">
                    <a href="#" class="mobile-nav__toggler"
                    ><i class="fa fa-bars"></i
                    ></a>
                    <ul class="main-menu__list">
                    <li class="">
                        <a :href="route('home')" data-i18n-key="header_home">Home</a>
                    </li>
                    <li class="">
                        <a :href="route('about')" data-i18n-key="header_about">About</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-i18n-key="header_services">Services</a>
                        <ul>
                        <li>
                            <a :href="route('companies')" data-i18n-key="header_companies"
                            >Companies</a
                            >
                        </li>
                        <li>
                            <a
                            :href="route('for_the_non_profit')"
                            data-i18n-key="header_non_profit"
                            >Non-Profit</a
                            >
                        </li>
                        <li>
                            <a
                            :href="route('for_families_and_individuals')"
                            data-i18n-key="header_individuals_and_families"
                            >Individuals and Families</a
                            >
                        </li>
                        <li>
                            <a
                            :href="route('foreign_companies')"
                            data-i18n-key="header_foreign_companies"
                            >Foreign Companies</a
                            >
                        </li>
                        </ul>
                    </li>
                    <li class="">
                        <a
                        :href="route('news_insights')"
                        data-i18n-key="header_news_insights"
                        >News & Insights</a
                        >
                    </li>
                    <li class="">
                        <a
                        :href="route('mission_and_values')"
                        data-i18n-key="header_mission_values"
                        >Mission & Values</a
                        >
                    </li>
                    <li>
                        <a :href="route('contact')" data-i18n-key="header_contact"
                        >Contact</a
                        >
                    </li>
                    </ul>
                </div>
                <div class="main-menu-wrapper__right">
                    <a
                    :href="route('contact')"
                    class="thm-btn welcome-one__btn text-white"
                    data-i18n-key="get_a_quote"
                    >Get a Quote</a
                    >
                </div>
            </div>
        </nav>
    </header>

    <div class="stricky-header stricked-menu main-menu">
        <div class="sticky-header__content">
            <div class="main-menu-wrapper">
                <div class="main-menu-wrapper__logo">
                    <a :href="route('home')">

                    <img
                        src="/images/resources/logo-1.png"
                        style="width: 100px"
                        alt=""
                    />
                    </a>
                </div>
                <div class="main-menu-wrapper__main-menu">
                    <a href="#" class="mobile-nav__toggler"
                    ><i class="fa fa-bars"></i
                    ></a>
                    <ul class="main-menu__list">
                    <li class="">
                        <a :href="route('home')" data-i18n-key="header_home">Home</a>
                    </li>
                    <li class="">
                        <a :href="route('about')" data-i18n-key="header_about">About</a>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-i18n-key="header_services">Services</a>
                        <ul>
                        <li>
                            <a :href="route('companies')" data-i18n-key="header_companies"
                            >Companies</a
                            >
                        </li>
                        <li>
                            <a
                            :href="route('for_the_non_profit')"
                            data-i18n-key="header_non_profit"
                            >Non-Profit</a
                            >
                        </li>
                        <li>
                            <a
                            :href="route('for_families_and_individuals')"
                            data-i18n-key="header_individuals_and_families"
                            >Individuals and Families</a
                            >
                        </li>
                        <li>
                            <a
                            :href="route('foreign_companies')"
                            data-i18n-key="header_foreign_companies"
                            >Foreign Companies</a
                            >
                        </li>
                        </ul>
                    </li>
                    <li class="">
                        <a
                        :href="route('news_insights')"
                        data-i18n-key="header_news_insights"
                        >News & Insights</a
                        >
                    </li>
                    <li class="">
                        <a
                        :href="route('mission_and_values')"
                        data-i18n-key="header_mission_values"
                        >Mission & Values</a
                        >
                    </li>
                    <li>
                        <a :href="route('contact')" data-i18n-key="header_contact"
                        >Contact</a
                        >
                    </li>
                    </ul>
                </div>
                <div class="main-menu-wrapper__right">
                    <a
                    :href="route('contact')"
                    class="thm-btn welcome-one__btn text-white"
                    data-i18n-key="get_a_quote"
                    >Get a Quote</a
                    >
                </div>
            </div>
        </div>
    </div>

    <div v-if="componentName !== 'Home'">
        <section v-if="componentName == 'About'" class="page-header">
            <div
                class="page-header-bg"
                style="background-image: url(/images/backgrounds/own-hero.png)" >
            </div>
            <div class="container">
                <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                    <li>
                    <a
                        :href="route('home')"
                        class="notranslate"
                        id="header-menu-contact-link-bread"
                        data-i18n-key="header_home"
                        >Home</a
                    >
                    </li>
                    <li
                    class="notranslate"
                    id="bread-about-text"
                    data-i18n-key="about_breadcrumb"
                    >
                    About
                    </li>
                </ul>
                <h2 data-i18n-key="about_us_heading">About us</h2>
                </div>
            </div>
        </section>

        <section v-if="componentName == 'Companies'" class="page-header">
            <div
            class="page-header-bg"
            style="
                background-image: url(/images/backgrounds/companies-page.png);
            "
            ></div>
            <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                <li>
                    <a
                    :href="route('home')"
                    class="notranslate"
                    id="header-menu-contact-link-bread"
                    data-i18n-key="header_home"
                    >Home</a
                    >
                </li>
                <li data-i18n-key="companies_title">Companies</li>
                </ul>
                <h2 data-i18n-key="companies_title">Companies</h2>
            </div>
            </div>
        </section>

        <section v-if="componentName == 'Contact'" class="page-header">
            <div
            class="page-header-bg"
            style="background-image: url(/images/backgrounds/contact.png)"
            ></div>
            <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                <li>
                    <a :href="route('home')" data-i18n-key="header_home">Home</a>
                </li>
                <li class="notranslate" data-i18n-key="header_contact">
                    Contact
                </li>
                </ul>
                <h2 data-i18n-key="header_contact">Contact</h2>
            </div>
            </div>
        </section>

        <section v-if="componentName == 'ForFamiliesAndIndividuals'" class="page-header">
            <div
            class="page-header-bg"
            style="
                background-image: url(/images/backgrounds/for-families.png);
            "
            ></div>
            <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                <li>
                    <a
                    :href="route('home')"
                    class="notranslate"
                    id="header-menu-contact-link-bread"
                    >Home</a
                    >
                </li>
                <li data-i18n-key="header_individuals_and_families">
                    for families and Individuals
                </li>
                </ul>
                <h2 data-i18n-key="header_individuals_and_families">
                Individuals and Families
                </h2>
            </div>
            </div>
        </section>

        <section v-if="componentName == 'ForTheNonProfit'" class="page-header">
            <div
            class="page-header-bg"
            style="
                background-image: url(/images/backgrounds/for-the-none-profit.png);
            "
            ></div>
            <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                <li>
                    <a
                    :href="route('home')"
                    class="notranslate"
                    id="header-menu-contact-link-bread"
                    >Home</a
                    >
                </li>
                <li class="notranslate" data-i18n-key="non_profit_title">
                    For the Non-profit
                </li>
                </ul>
                <h2 class="notranslate" data-i18n-key="non_profit_title">
                    For the Non-profit
                </h2>
            </div>
            </div>
        </section>

        <section v-if="componentName == 'ForeignComapnies'" class="page-header">
            <div
            class="page-header-bg"
            style="
                background-image: url(/images/backgrounds/companies-page.png);
            "
            ></div>
            <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                <li>
                    <a
                    :href="route('home')"
                    class="notranslate"
                    id="header-menu-contact-link-bread"
                    data-i18n-key="header_home"
                    >Home</a
                    >
                </li>
                <li data-i18n-key="companies_title">Foreign Companies</li>
                </ul>
                <h2 data-i18n-key="companies_title">Foreign Companies</h2>
            </div>
            </div>
        </section>

        <section v-if="componentName == 'MissionAndValues'" class="page-header">
            <div
            class="page-header-bg"
            style="
                background-image: url(/images/backgrounds/missionvalues.png);
            "
            ></div>
            <div class="container">
            <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                <li>
                    <a :href="route('home')" data-i18n-key="header_home">Home</a>
                </li>
                <li data-i18n-key="mission_values_breadcrumb">
                    Mission & Values
                </li>
                </ul>
                <h2 data-i18n-key="mission_values_heading">Mission & Values</h2>
            </div>
            </div>
        </section>

        <section v-if="componentName == 'NewsInsights'" class="page-header">
            <div
                class="page-header-bg"
                style="
                background-image: url(/images/backgrounds/newsinsights.png);
                "
            ></div>
            <div class="container">
                <div class="page-header__inner">
                <ul class="thm-breadcrumb list-unstyled">
                    <li>
                    <a
                        :href="route('home')"
                        class="notranslate"
                        id="header-menu-contact-link-bread"
                        >Home</a
                    >
                    </li>
                    <li data-i18n-key="newsinsights_title">News & Insights</li>
                </ul>
                <h2 data-i18n-key="newsinsights_title">News & Insights</h2>
                </div>
            </div>
        </section>

        <section v-if="componentName == '404'" class="error-page">
        <div class="container">
            <div class="row">
            <div class="col-xl-12">
                <div class="error-page__inner">
                <h2 data-i18n-key="not_found_title">Page Not Found</h2>
                <h3 class="error-page__tagline">
                    Sorry We Can't Find <br />
                    That Page!
                </h3>
                <p class="error-page__text">
                    The page you are looking for was never existed.
                </p>

                <a :href="route('home')" class="thm-btn error-page__btn mt-5"
                    >back to home</a
                >
                </div>
            </div>
            </div>
        </div>
        </section>
    </div>
</template>
