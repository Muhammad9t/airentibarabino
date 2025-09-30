<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div>

        <section class="error-page">
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

                    <Link :href="route('index')" class="thm-btn error-page__btn mt-5"
                        >back to home</Link
                    >
                </div>
                </div>
            </div>
            </div>
        </section>

    </div>
</template>
