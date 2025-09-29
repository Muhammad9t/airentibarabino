<script setup>
    import FrontEndLayout from '@/Layouts/FrontEndLayout.vue';
    import { useLanguage } from '@/Composables/useLanguage.js';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        services: Array
    });

    const { getTranslatedText } = useLanguage();
</script>

<template>
    <FrontEndLayout>

        <section class="why-choose-one mt-5">
            <div class="container">
                <div
                    class="section-title text-left wow bounceInLeft"
                    data-wow-delay="100ms"
                    data-wow-duration="500ms"
                >
                    <span class="section-title__tagline" data-i18n-key="what_we_offer"
                    >What we offer</span
                    >

                    <h2 data-i18n-key="section_title" class="notranslate"></h2>
                    <div class="divider"></div>
                </div>
                <div
                    class="row wow fadeInLeft center"
                    data-wow-delay="100ms"
                    data-wow-duration="200ms"
                >
                    <div 
                        v-for="service in services" 
                        :key="service.id"
                        class="col-xl-6 mt-4"
                    >
                        <div class="professional-card">
                            <div class="why-choose-one__right m-0">
                                <div class="section-title text-left">
                                    <h2 class="we-care__title">
                                        {{ getTranslatedText(service.name_translations, service.name) }}
                                    </h2>
                                </div>

                                <div class="why-choose-one__content mt-0">
                                    <div class="why-choose-one__content-list">
                                        <ul class="list-unstyled why-choose-one__points">
                                            <li v-for="subService in service.sub_services" :key="subService.id">
                                                <div class="icon">
                                                    <span class="icon-check"></span>
                                                </div>
                                                <div class="text">
                                                    <p>{{ getTranslatedText(subService.title_translations, subService.title) }}</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <Link
                                :href="`/service/${service.slug}`"
                                class="thm-btn welcome-one__btn mt-4"
                            >
                                LEGGI DI PIÙ
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="welcome-one">
            <div class="welcome-one-shape wow slideInLeft" data-wow-delay="100ms" data-wow-duration="2500ms">
                <img src="/images/shapes/welcom-one-shape.png" alt="" />
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 wow bounceInLeft" data-wow-delay="100ms" data-wow-duration="1200ms">
                        <div class="welcome-one__left">
                            <div class="welcome-one__img-box">
                            <div class="welcome-one__img">
                                <img src="/images/resources/abGroup.png" alt="" />
                            </div>
                            <div class="welcome-one__experience">
                                <div class="welcome-one__experience-icon">
                                <span class="icon-conversation"></span>
                                </div>
                                <div class="welcome-one__experience-content">
                                <h3 class="welcome-one__experience-title">
                                    <span>40</span>
                                    <span data-i18n-key="years_of_working_experience"
                                    >Years of Working Experience</span
                                    >
                                </h3>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="about-page__right">
                            <div class="section-title text-left">
                                <span
                                    class="section-title__tagline"
                                    data-i18n-key="our_introductions"
                                    >Our Introductions</span
                                >
                                <h2 data-i18n-key="we_are_chartered_accountants">
                                    We are Chartered Accountants and Accounting Experts
                                </h2>
                            </div>
                            <div class="divider"></div>
                            <p
                            class="about-page__right-text-1"
                            data-i18n-key="firm_founded_in_1998"
                            >
                            The firm was founded in 1998 by combining the experience and
                            professionalism that Dr. Piero Airenti and Dr. Andrea Barabino
                            had acquired over a decade of practice.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="welcome-three">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                    <div class="welcome-three__left">
                        <div class="section-title text-left">
                        <span
                            class="section-title__tagline"
                            data-i18n-key="corporate_consultancy"
                            >Corporate consultancy</span
                        >
                        <h2
                            data-i18n-key="corporate_consultancy_and_extraordinary_transactions"
                        >
                            Corporate consultancy and extraordinary transactions
                        </h2>
                        </div>
                        <div class="divider"></div>
                        <p
                        class="welcome-three__text"
                        data-i18n-key="corporate_consultancy_text"
                        >
                        Drafting of articles of association of companies and entities;
                        Extraordinary transactions (mergers, demergers,
                        transformations, company purchases, etc.); Keeping minutes of
                        shareholders' meetings and board of directors; Contracts.
                        </p>
                    </div>
                    </div>
                    <div class="col-xl-6">
                    <div class="welcome-three__right">
                        <div
                        class="welcome-three__img-box wow bounceInLeft"
                        data-wow-delay="100ms"
                        data-wow-duration="1200ms"
                        style="
                            visibility: visible;
                            animation-duration: 2500ms;
                            animation-delay: 100ms;
                            animation-name: slideInRight;
                        "
                        >
                        <div class="welcome-three-img">
                            <img src="/images/resources/abgroup2.png" alt="" />
                        </div>
                        <!-- <div class="welcome-three__small-img">
                            <img
                            src="/images/resources/ai-generated-three.png"
                            alt=""
                            />
                        </div> -->
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="welcome-three">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                    <div class="welcome-three__right">
                        <div
                        class="welcome-three__img-box wow bounceInLeft"
                        data-wow-delay="100ms"
                        data-wow-duration="1200ms"
                        style="
                            visibility: visible;
                            animation-duration: 2500ms;
                            animation-delay: 100ms;
                            animation-name: slideInLeft;
                        "
                        >
                        <div class="welcome-three-img">
                            <img src="/images/resources/book.png" alt="" />
                        </div>
                        <div class="welcome-three__small-img bordered-red">
                            <img src="/images/resources/org.png" alt="" />
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-xl-6 mt-4">
                    <div class="welcome-three__left">
                        <div class="section-title text-left">
                        <span
                            class="section-title__tagline"
                            data-i18n-key="real_estate"
                            >Real estate</span
                        >
                        <h2
                            data-i18n-key="asset_management_and_real_estate_management"
                        >
                            Asset Management and Real Estate Management
                        </h2>
                        </div>
                        <div class="divider"></div>
                        <p class="welcome-three__text" data-i18n-key="real_estate_text">
                        Consulting in the management of movable and immovable
                        and their transmission in the context of inheritance;
                        Consulting on the taxation of rentals and sales; Calculations,
                        declarations, payments for local taxes (IMU, TASI); Drafting
                        and registration of rental contracts; Calculation of
                        registration taxes and preparation of payment forms.
                        </p>
                    </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="welcome-three">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                    <div class="welcome-three__left">
                        <div class="section-title text-left">
                        <span
                            class="section-title__tagline"
                            data-i18n-key="foreign_companies"
                            >Foriegn companies</span
                        >
                        <h2
                            data-i18n-key="reception_of_foreign_companies_and_investors"
                        >
                            Reception of foreign companies and investors in Italy
                        </h2>
                        </div>
                        <div class="divider"></div>
                        <p
                        class="welcome-three__text"
                        data-i18n-key="foreign_companies_text"
                        >
                        Assignment in Italy of the VAT identification number, for
                        non-residents, to operate directly in Italy; Management of VAT
                        accounting and tax payments, accounting and tax assistance for
                        the management of permanent establishments in Italy of
                        non-resident subjects; Assistance and advice and much more.
                        </p>
                    </div>
                    </div>
                    <div class="col-xl-6">
                    <div class="welcome-three__right">
                        <div
                        class="welcome-three__img-box wow bounceInRight"
                        data-wow-delay="100ms"
                        data-wow-duration="1200ms"
                        style="
                            visibility: visible;
                            animation-duration: 2500ms;
                            animation-delay: 100ms;
                            animation-name: slideInRight;
                        "
                        >
                        <div class="welcome-three-img">
                            <img src="/images/resources/page.png" alt="" />
                        </div>
                        <div class="welcome-three__small-img bordered-red">
                            <img src="/images/resources/original.png" alt="" />
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-one mt-5 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                    <div class="cta-one__inner">
                        <div class="cta-one__box-1"></div>
                        <div class="cta-one__box-2"></div>
                        <div class="cta-one__left">
                        <div class="cta-one__title-box">
                            <h4
                            class="cta-one__title"
                            data-i18n-key="we_invite_you_to_contact_us"
                            >
                            We invite you to contact us
                            </h4>
                            <p class="text-white" data-i18n-key="contact_us_text">
                            By phone or email we are at your disposal and you can find
                            us in Turin and Genoa.
                            </p>
                        </div>
                        </div>
                        <div class="cta-one__right">
                        <a
                            href="contact.html"
                            class="thm-btn cta-one__btn"
                            data-i18n-key="lets_get_started"
                            >let's get started</a
                        >
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </section>

    </FrontEndLayout>
</template>
