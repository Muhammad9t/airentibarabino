<script setup>
import { ref, computed } from 'vue'
import { useLanguage } from '../Composables/useLanguage.js'
import MultilingualText from './MultilingualText.vue'
import MultilingualList from './MultilingualList.vue'

const props = defineProps({
    services: {
        type: Array,
        default: () => []
    }
})

const { getTranslatedText, getTranslatedArray, language } = useLanguage()

const expandedTitles = ref(new Set())

function toggleTitle(titleId) {
    if (expandedTitles.value.has(titleId)) {
        expandedTitles.value.delete(titleId)
    } else {
        expandedTitles.value.add(titleId)
    }
}

function isTitleExpanded(titleId) {
    return expandedTitles.value.has(titleId)
}

// Helper functions for multilingual content
const getServiceName = (service) => {
    return getTranslatedText(service.name_translations, service.name)
}

const getServiceDescription = (service) => {
    return getTranslatedText(service.description_translations, service.description)
}

const getSubServiceTitle = (subService) => {
    return getTranslatedText(subService.title_translations, subService.title)
}

const getSubServicePoints = (subService) => {
    return getTranslatedArray(subService.points_translations, subService.points || [])
}

// Initialize expanded titles based on is_expanded property
props.services.forEach(service => {
    if (service.sub_services) {
        service.sub_services.forEach(subService => {
            if (subService.is_expanded) {
                expandedTitles.value.add(subService.id)
            }
        })
    }
})
</script>

<template>
    <div class="services-hierarchy">
        <template v-for="service in services" :key="service.id">
            <div class="service-category mb-4">
                <div v-if="service.sub_services && service.sub_services.length > 0" class="service-details__faq">
                    <div class="accrodion-grp faq-one-accrodion" data-grp-name="faq-one-accrodion">
                        <div 
                            v-for="(subService, index) in service.sub_services" 
                            :key="subService.id"
                            class="accrodion"
                            :class="{ 
                                'active': isTitleExpanded(subService.id),
                                'last-chiled': index === service.sub_services.length - 1
                            }"
                        >
                            <div class="accrodion-title" @click="toggleTitle(subService.id)">
                                <h4>{{ getSubServiceTitle(subService) }}</h4>
                            </div>
                            <div 
                                class="accrodion-content" 
                                :style="isTitleExpanded(subService.id) ? '' : 'display: none'"
                            >
                                <div class="inner">
                                    <MultilingualList 
                                        :translations="subService.points_translations"
                                        :language="language"
                                        :fallback-text="'No points available.'"
                                    />
                                </div>
                                <!-- /.inner -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<style scoped>
.service-category {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1.5rem;
    background-color: #fff;
}


/* Accordion styling to match template */
.accrodion-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.3s ease;
}

.accrodion-title:hover {
    background-color: #f8f9fa;
}

.accrodion-title h4 {
    margin: 0;
    flex: 1;
}

.accrodion.active .accrodion-title {
    background-color: #e3f2fd;
    border-bottom-color: #2196f3;
}

.accrodion-content {
    padding: 1rem;
    background-color: #fafafa;
}

.accrodion-content .inner ul {
    margin: 0;
    padding-left: 1.5rem;
}

.accrodion-content .inner li {
    margin-bottom: 0.5rem;
    line-height: 1.6;
    color: #555;
}
</style>
