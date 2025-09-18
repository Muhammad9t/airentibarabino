<script setup>
    import FrontEndLayout from '@/Layouts/FrontEndLayout.vue';
</script>

<template>
    <FrontEndLayout>

        <section class="about-page">
            <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                <div class="about-page__left">
                    <ul class="list-unstyled about-page__images">
                    <li class="display__none__small">
                        <div
                        class="wow bounceInRight"
                        data-wow-delay="100ms"
                        data-wow-duration="1000ms"
                        >
                        <img src="/images/contact/a&b-own.png" alt="" />
                        </div>
                    </li>
                    <li>
                        <div
                        class="wow bounceInLeft"
                        data-wow-delay="100ms"
                        data-wow-duration="1000ms"
                        >
                        <img src="/images/contact/a&b2-own.png" alt="" />
                        </div>
                    </li>
                    </ul>
                </div>
                </div>
                <div class="col-xl-6">
                <div class="welcome-one__right">
                    <div class="section-title">
                    <!-- <span
                        class="section-title__tagline"
                        data-i18n-key="about_intro_tagline"
                        >Our introductions</span
                    > -->
                    <h2 data-i18n-key="about_intro_title">
                        For over 30 years a point of reference.
                    </h2>
                    </div>
                    <div class="divider"></div>

                    <p data-i18n-key="about_intro_text">
                    Airenti & Barabino offers consulting services ensuring
                    competence, seriousness and confidentiality, thanks to a team
                    of people who have been operating in Turin and Genoa for over
                    thirty years. At Airenti & Barabino you will always have a
                    direct relationship with your trusted professional.
                    </p>
                </div>
                <!-- <div class="about-page__right">
                    <div class="section-title text-left">
                    <span class="section-title__tagline">about company</span>
                    <h2 class="">
                        We are Chartered Accountants and Accounting Experts
                    </h2>
                    </div>
                    <div class="divider"></div>
                    <p class="about-page__right-text-1">
                    The firm was founded in 1998 by combining the experience and
                    professionalism that Dr. Piero Airenti and Dr. Andrea Barabino
                    had acquired over a decade of practice.
                    </p>
                </div> -->
                </div>
            </div>
            </div>
        </section>

        <section class="team-one">
            <div class="container">
            <div class="section-title text-center">
                <!-- <span
                class="section-title__tagline"
                data-i18n-key="team_section_tagline"
                >people behind it</span
                > -->
                <h2 data-i18n-key="team_section_title">Meet the partners</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="team-flip-card">
                    <div class="team-flip-card-inner">
                    <div class="team-flip-card-front">
                        <img
                        src="/images/team/DSC_5611-min-scaled.jpg"
                        alt="Dr. Andrea Barabino"
                        />
                    </div>
                    <div class="team-flip-card-back">
                        <h3 data-i18n-key="team_andrea_name">
                        Dr. Andrea Barabino
                        </h3>
                        <p data-i18n-key="team_andrea_role">Chartered Accountant</p>
                        <p data-i18n-key="team_andrea_desc">
                        Specializing in tax and corporate consulting,
                        international taxation, and assistance to foreign
                        companies.
                        </p>
                        <a
                        href="https://www.linkedin.com/in/andrea-barabino-b1aa552/"
                        class="linkedin-icon"
                        target="_blank"
                        ><i class="fab fa-linkedin-in"></i
                        ></a>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="team-flip-card">
                    <div class="team-flip-card-inner">
                    <div class="team-flip-card-front">
                        <img
                        src="/images/team/DSC_5611-min-scaledbs.png"
                        alt="Dr. Piero Airenti"
                        />
                    </div>
                    <div class="team-flip-card-back">
                        <h3 data-i18n-key="team_piero_name">Dr. Piero Airenti</h3>
                        <p data-i18n-key="team_piero_role">Chartered Accountant</p>
                        <p data-i18n-key="team_piero_desc">
                        Specializing in tax and corporate consultancy, contracts,
                        tax litigation.
                        </p>
                        <a
                        href="https://www.linkedin.com/in/piero-airenti-8311725/"
                        class="linkedin-icon"
                        target="_blank"
                        ><i class="fab fa-linkedin-in"></i
                        ></a>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="team-flip-card">
                    <div class="team-flip-card-inner">
                    <div class="team-flip-card-front">
                        <img
                        src="/images/team/DSC_5611-min-scaledas.png"
                        alt="Dr. Elisa Correndo"
                        />
                    </div>
                    <div class="team-flip-card-back">
                        <h3 data-i18n-key="team_elisa_name">Dr. Elisa Correndo</h3>
                        <p data-i18n-key="team_elisa_role">Accounting expert</p>
                        <p data-i18n-key="team_elisa_desc">
                        Specializing in tax and corporate consultancy, labor
                        consultancy.
                        </p>
                        <a
                        href="https://www.linkedin.com/in/elisa-correndo-101754157/"
                        class="linkedin-icon"
                        target="_blank"
                        ><i class="fab fa-linkedin-in"></i
                        ></a>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section>

        <section class="welcome-three">
            <div class="container">
            <div class="row">
                <div class="col-lg-6">
                <h2 data-i18n-key="years_of_experience">YEARS OF EXPERIENCE</h2>
                <div class="counter-number counter-grid" data-target="40">0</div>
                </div>
                <div class="col-lg-6">
                <h2 data-i18n-key="locations_turin_genoa">
                    LOCATIONS: TURIN-GENOA
                </h2>
                <div class="counter-number counter-grid" data-target="2">0</div>
                </div>
            </div>
            </div>
        </section>

    </FrontEndLayout>
</template>



