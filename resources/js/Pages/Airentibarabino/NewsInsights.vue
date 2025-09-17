<script setup>
    import FrontendLayout from '@/Layouts/FrontendLayout.vue';
</script>

<template>
    <FrontendLayout>

        <section class="py-5 mt-5">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-12">
                    <h2 class="fw-bold" data-i18n-key="latest_news_articles">
                        Latest News & Articles
                    </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <img
                            src="/images/resources/_DSC5173.jpg"
                            alt=""
                            class="img-fluid"
                        />
                        <div class="mt-5">
                            <span
                            class="section-title__tagline"
                            data-i18n-key="latest_news"
                            ></span>
                            <h2 class="" data-i18n-key="expense_reimbursements_title"></h2>
                            <p
                            class="card-text"
                            data-i18n-key="expense_reimbursements_para1"
                            ></p>
                            <p
                            class="card-text"
                            data-i18n-key="expense_reimbursements_para2"
                            ></p>
                            <p
                            class="card-text"
                            data-i18n-key="expense_reimbursements_para3"
                            ></p>

                            <b data-i18n-key="ets_tax_regime_title"></b>
                            <p class="card-text" data-i18n-key="ets_tax_regime_para"></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </FrontendLayout>
</template>
