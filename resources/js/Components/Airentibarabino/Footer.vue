<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const settings = computed(() => page.props.settings);
const services = computed(() => page.props.services ?? []);

const { getTranslatedText } = useLanguage();
import { useLanguage } from "../../Composables/useLanguage.js";
</script>

<template>
    <footer class="site-footer mt-5">
        <div class="site-footer__top">
            <div
                class="site-footer__top-shape"
                style="
                    background-image: url(/images/shapes/site-footer-top-shape.png);
                "
            ></div>
            <div class="container">
                <div class="site-footer__top-inner">
                    <div class="site-footer__top-left">
                        <h3
                            class="site-footer__top-left-title"
                            data-i18n-key="we_are_on_social_media"
                        >
                            We are on social media as well
                        </h3>
                        <a
                            href="tel:926668880000"
                            class="site-footer__top-left-phone"
                            data-i18n-key="join_us_there"
                            >Join us there</a
                        >
                    </div>
                    <div class="site-footer__top-right">
                        <div class="site-footer__top-right-social">
                            <a
                                href="https://www.linkedin.com/search/results/all/?heroEntityKey=urn%3Ali%3Aorganization%3A102525316&keywords=Airenti%20%26%20Barabino&origin=ENTITY_SEARCH_HOME_HISTORY&sid=!Y2"
                                ><i class="fab fa-linkedin-in"></i
                            ></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-footer__middle">
            <div class="container">
                <div class="site-footer__middle-inner">
                    <div class="row">
                        <!-- <div
                  class="col-xl-4 col-lg-4 wow fadeInUp"
                  data-wow-delay="100ms"
                >
                  <div class="footer-widget__column footer-widget__contact">
                    <h3
                      class="footer-widget__title"
                      data-i18n-key="contact_turin"
                    >
                      Contact
                    </h3>
                    <p
                      class="footer-widget__contact-text text-white"
                      data-i18n-key="turin_address"
                    >
                      Turin, Corso Vittorio Emanuele II 52
                    </p>
                    <h4 class="footer-widget__contact-email-phone">
                      <a
                        href="https://mail.google.com/mail/?view=cm&fs=1&to=torino@airentiebarabino.com"
                        target="_blank"
                        class="footer-widget__contact-email"
                        data-i18n-key="turin_email"
                        >torino@airentiebarabino.com</a
                      >
                      <a
                        href="tel:926668880000"
                        class="footer-widget__contact-phone"
                        data-i18n-key="turin_phone"
                        >+39.011.506.3073</a
                      >
                    </h4>
                  </div>
                </div>
                <div
                  class="col-xl-4 col-lg-4 wow fadeInUp"
                  data-wow-delay="100ms"
                >
                  <div class="footer-widget__column footer-widget__contact">
                    <h3
                      class="footer-widget__title"
                      data-i18n-key="contact_genoa"
                    >
                      Contact
                    </h3>
                    <p
                      class="footer-widget__contact-text text-white"
                      data-i18n-key="genoa_address"
                    >
                      Genoa, Via Ceccardi 4/20
                    </p>
                    <h4 class="footer-widget__contact-email-phone">
                      <a
                        href="https://mail.google.com/mail/?view=cm&fs=1&to=genova@airentiebarabino.com"
                        target="_blank"
                        class="footer-widget__contact-email"
                        data-i18n-key="genoa_email"
                        >genova@airentiebarabino.com</a
                      >
                      <a
                        href="tel:+39010580386"
                        class="footer-widget__contact-phone"
                        data-i18n-key="genoa_phone"
                        >+39.010.580.386</a
                      >
                    </h4>
                  </div>
                </div> -->

                        <div
                            class="col-xl-4 col-lg-4 wow fadeInUp"
                            data-wow-delay="100ms"
                        >
                            <div
                                class="footer-widget__column footer-widget__contact"
                            >
                                <h3 class="footer-widget__title">
                                    {{ settings?.city_one }} Office
                                </h3>
                                <p
                                    class="footer-widget__contact-text text-white"
                                >
                                    {{ settings?.city_one }},
                                    {{ settings?.address_one }}
                                </p>
                                <h4 class="footer-widget__contact-email-phone">
                                    <a
                                        v-if="settings?.email_one"
                                        :href="`mailto:${settings.email_one}`"
                                        target="_blank"
                                        class="footer-widget__contact-email"
                                    >
                                        {{ settings.email_one }}
                                    </a>
                                    <a
                                        v-if="settings?.phone_one"
                                        :href="`tel:${settings.phone_one}`"
                                        class="footer-widget__contact-phone"
                                    >
                                        {{ settings.phone_one }}
                                    </a>
                                </h4>
                            </div>
                        </div>

                        <div
                            class="col-xl-4 col-lg-4 wow fadeInUp"
                            data-wow-delay="100ms"
                        >
                            <div
                                class="footer-widget__column footer-widget__contact"
                            >
                                <h3 class="footer-widget__title">
                                    {{ settings?.city_two }} Office
                                </h3>
                                <p
                                    class="footer-widget__contact-text text-white"
                                >
                                    {{ settings?.city_two }},
                                    {{ settings?.address_two }}
                                </p>
                                <h4 class="footer-widget__contact-email-phone">
                                    <a
                                        v-if="settings?.email_two"
                                        :href="`mailto:${settings.email_two}`"
                                        target="_blank"
                                        class="footer-widget__contact-email"
                                    >
                                        {{ settings.email_two }}
                                    </a>
                                    <a
                                        v-if="settings?.phone_two"
                                        :href="`tel:${settings.phone_two}`"
                                        class="footer-widget__contact-phone"
                                    >
                                        {{ settings.phone_two }}
                                    </a>
                                </h4>
                            </div>
                        </div>

                        <div
                            class="col-xl-4 col-lg-4 wow fadeInUp"
                            data-wow-delay="200ms"
                        >
                            <div
                                class="footer-widget__column footer-widget__links clearfix"
                            >
                                <h3
                                    class="footer-widget__title"
                                    data-i18n-key="quick_links"
                                >
                                    Quick Links
                                </h3>
                                <ul
                                    class="footer-widget__links-list list-unstyled clearfix"
                                >
                                    <li v-for="item in services" :key="item.id">
                                        <Link
                                            :href="
                                                route(
                                                    'services.show',
                                                    item.slug
                                                )
                                            "
                                            class="text-white"
                                        >
                                            {{
                                                getTranslatedText(
                                                    item.name_translations,
                                                    item.name
                                                )
                                            }}
                                        </Link>
                                    </li>
                                    <!-- <li>
                        <Link
                          :href="route('companies')"
                          class="text-white"
                          data-i18n-key="footer_companies"
                          >Companies</Link
                        >
                      </li>
                      <li>
                        <Link
                          :href="route('for_the_non_profit')"
                          class="text-white notranslate"
                          data-i18n-key="footer_non_profit"
                          >Non-profit</Link
                        >
                      </li>
                      <li>
                        <Link
                          :href="route('for_families_and_individuals')"
                          class="text-white"
                          data-i18n-key="footer_individuals_families"
                          >Individuals & Families</Link
                        >
                      </li>
                      <li>
                        <Link
                          :href="route('foreign_companies')"
                          class="text-white"
                          data-i18n-key="footer_foreign_companies"
                          >Foreign Companies</Link
                        >
                      </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-footer__bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="site-footer__bottom-inner d-flex">
                            <p class="site-footer__bottom-text text-white">
                                © {{ new Date().getFullYear() }}
                            </p>
                            &nbsp;
                            <p
                                class="site-footer__bottom-text text-white notranslate"
                                data-i18n-key="all_rights_reserved_designed_by"
                            >
                                All rights reserved | Designed and developed by
                            </p>
                            &nbsp;
                            <p class="site-footer__bottom-text text-white">
                                <a
                                    target="_blank"
                                    href="https://outscalers.com/"
                                    class="text-primary"
                                >
                                    Outscalers</a
                                >
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
