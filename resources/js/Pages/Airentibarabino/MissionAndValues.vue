<script setup>
import { useLanguage } from '@/Composables/useLanguage.js';

const { getTranslatedText } = useLanguage();

// Mission and values content
const missionContent = {
    para1: {
        it: "Da Airenti & Barabino ciascun cliente è seguito ed assistito direttamente dai partners, con un approccio personalizzato ed attento alla qualità della prestazione.",
        en: "At Airenti & Barabino, each client is followed and assisted directly by the partners, with a personalized approach attentive to the quality of service.",
        fr: "Chez Airenti & Barabino, chaque client est suivi et assisté directement par les associés, avec une approche personnalisée et attentive à la qualité du service."
    },
    para2: {
        it: "Siamo uno studio indipendente, abbiamo quindi la possibilità di fornire a ciascuno un servizio \"sartoriale\", assicurando contestualmente professionalità, disponibilità e riservatezza.",
        en: "We are an independent firm, so we have the opportunity to provide each client with a \"tailored\" service, ensuring professionalism, availability and confidentiality.",
        fr: "Nous sommes un cabinet indépendant, nous avons donc la possibilité de fournir à chacun un service \"sur mesure\", en assurant professionnalisme, disponibilité et confidentialité."
    },
    para3: {
        it: "Nel nostro lavoro abbiamo sempre un occhio di riguardo al rispetto dell'ambiente e alla sua sostenibilità.",
        en: "In our work we always have an eye for respect for the environment and its sustainability.",
        fr: "Dans notre travail, nous avons toujours un œil pour le respect de l'environnement et sa durabilité."
    }
};
</script>

<template>
    <div>
        <section class="py-5 mt-5">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12">
                        <h2 class="section-heading text-center mb-4">
                            {{ getTranslatedText(missionContent.para1) }}
                        </h2>
                        <h2 class="section-heading text-center mb-4">
                            {{ getTranslatedText(missionContent.para2) }}
                        </h2>
                        <h2 class="section-heading text-center">
                            {{ getTranslatedText(missionContent.para3) }}
                        </h2>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
