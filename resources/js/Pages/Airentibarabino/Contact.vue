<script setup>
    import FrontEndLayout from '@/Layouts/FrontEndLayout.vue';
</script>

<template>
    <FrontEndLayout>

        <section class="contact-page">
            <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="row">
                        <div class="col-lg-12">
                            <div
                            id="carouselGenova"
                            class="carousel slide"
                            data-ride="carousel"
                            >
                            <div class="carousel-inner">
                                <div class="carousel-item active" data-interval="10000">
                                <img
                                    src="/images/contact/Torino-AB_To_DSC1473.jpeg"
                                    class="d-block w-100"
                                    alt="..."
                                />
                                </div>
                                <div class="carousel-item" data-interval="2000">
                                <img
                                    src="/images/contact/Genova_DSC0952B.png"
                                    class="d-block w-100"
                                    alt="..."
                                />
                                </div>
                            </div>
                            <a
                                class="carousel-control-prev"
                                href="#carouselGenova"
                                role="button"
                                data-bs-slide="prev"
                            >
                                <span
                                class="carousel-control-prev-icon"
                                aria-hidden="true"
                                ></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a
                                class="carousel-control-next"
                                href="#carouselGenova"
                                role="button"
                                data-bs-slide="next"
                            >
                                <span
                                class="carousel-control-next-icon"
                                aria-hidden="true"
                                ></span>
                                <span class="sr-only">Next</span>
                            </a>
                            </div>
                        </div>
                        <div class="col-lg-12 p-4">
                            <h3 data-i18n-key="torino_office">Our Torino Office</h3>
                            <hr />
                            <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            &nbsp;<small data-i18n-key="torino_address"
                                >Torino, Corso Vittorio Emanuele II 52</small
                            >
                            </div>
                            <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary"></i>
                            &nbsp;<small
                                ><a
                                href="https://mail.google.com/mail/?view=cm&fs=1&to=torino@airentiebarabino.com"
                                target="_blank"
                                data-i18n-key="torino_email"
                                style="color: inherit; text-decoration: none"
                                >torino@airentiebarabino.com</a
                                ></small
                            >
                            </div>
                            <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-primary"></i>
                            &nbsp;<small data-i18n-key="torino_phone"
                                >+39.011.506.3073</small
                            >
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="row">
                        <div class="col-lg-12">
                            <div
                            id="carouselTorino"
                            class="carousel slide"
                            data-ride="carousel"
                            >
                            <div class="carousel-inner">
                                <div class="carousel-item active" data-interval="10000">
                                <img
                                    src="/images/contact/Genova_DSC0952B.jpeg"
                                    class="d-block w-100"
                                    alt="..."
                                />
                                </div>
                                <div class="carousel-item" data-interval="2000">
                                <img
                                    src="/images/contact/Genova_DSC0952Bs.png"
                                    class="d-block w-100"
                                    alt="..."
                                />
                                </div>
                            </div>
                            <a
                                class="carousel-control-prev"
                                href="#carouselTorino"
                                role="button"
                                data-bs-slide="prev"
                            >
                                <span
                                class="carousel-control-prev-icon"
                                aria-hidden="true"
                                ></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a
                                class="carousel-control-next"
                                href="#carouselTorino"
                                role="button"
                                data-bs-slide="next"
                            >
                                <span
                                class="carousel-control-next-icon"
                                aria-hidden="true"
                                ></span>
                                <span class="sr-only">Next</span>
                            </a>
                            </div>
                        </div>
                        <div class="col-lg-12 p-4">
                            <h3 data-i18n-key="genova_office">Our Genova Office</h3>
                            <hr />
                            <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            &nbsp;<small data-i18n-key="genova_address"
                                >Genova, Via Ceccardi 4/20</small
                            >
                            </div>
                            <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary"></i>
                            &nbsp;<small
                                ><a
                                href="https://mail.google.com/mail/?view=cm&fs=1&to=genova@airentiebarabino.com"
                                target="_blank"
                                data-i18n-key="genova_email"
                                style="color: inherit; text-decoration: none"
                                >genova@airentiebarabino.com</a
                                ></small
                            >
                            </div>
                            <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-primary"></i>
                            &nbsp;<small data-i18n-key="genova_phone"
                                >+39.010.580.386</small
                            >
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <section class="contcat-page-google-map">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!3m2!1sen!2s!4v1752832795489!5m2!1sen!2s!6m8!1m7!1sTgzFpuXAYdiqq5vtoF3PCQ!2m2!1d45.06208629776108!2d7.681173946473912!3f3.8123025959168366!4f2.9315222576390596!5f0.7820865974627469"
                            width="600"
                            height="450"
                            style="border: 0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                    <div class="col-lg-6">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!4v1752833496235!6m8!1m7!1seqS21UVndTsn9XwwGJUXrQ!2m2!1d44.40550525328057!2d8.935829045743365!3f79.36953407158738!4f28.385392804557995!5f0.4000000000000002"
                            width="600"
                            height="450"
                            style="border: 0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                </div>
            </div>
        </section>

    </FrontEndLayout>
</template>
