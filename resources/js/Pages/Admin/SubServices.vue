<script setup>
import { ref, computed } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import MultilingualInput from '@/Components/Admin/MultilingualInput.vue'
import MultilingualArrayInput from '@/Components/Admin/MultilingualArrayInput.vue'
import { useLanguage } from '@/Composables/useLanguage.js'
import '../../../css/admin.css'
import { router } from '@inertiajs/vue3'

// Language composable
const { language, getTranslatedText, getTranslatedArray } = useLanguage()

// Modal states
const showSubServiceModal = ref(false)
const isEditingSubService = ref(false)
const editingSubService = ref(null)

const props = defineProps({
    service: {
        type: Object,
        required: true
    },
    subServices: {
        type: Array,
        default: () => []
    }
})

// Sub-service form
const subServiceForm = useForm({
    service_id: props.service.id,
    title: '',
    title_translations: { en: '', it: '', fr: '' },
    points: [],
    points_translations: { en: [], it: [], fr: [] },
    is_expanded: false,
    sort_order: 0,
    status: 'active',
    source_language: ''
})

// Search functionality
const search = ref('')
const filteredSubServices = computed(() =>
    props.subServices.filter(subService => {
        const translatedTitle = getTranslatedText(subService.title_translations, subService.title)
        if (!translatedTitle) return false
        return translatedTitle.toLowerCase().includes(search.value.toLowerCase())
    })
)

// Sub-service modal functions
function openAddSubServiceModal() {
    isEditingSubService.value = false
    editingSubService.value = null
    subServiceForm.defaults({
        service_id: props.service.id,
        title: '',
        title_translations: { en: '', it: '', fr: '' },
        points: [],
        points_translations: { en: [], it: [], fr: [] },
        is_expanded: false,
        sort_order: 0,
        status: 'active',
        source_language: ''
    })
    subServiceForm.reset()
    // Ensure translations are properly initialized
    subServiceForm.title_translations = { en: '', it: '', fr: '' }
    subServiceForm.points_translations = { en: [], it: [], fr: [] }
    showSubServiceModal.value = true
}

function openEditSubServiceModal(subService) {
    isEditingSubService.value = true
    editingSubService.value = subService
    subServiceForm.defaults({
        service_id: subService.service_id,
        title: subService.title,
        title_translations: subService.title_translations || { en: '', it: '', fr: '' },
        points: subService.points || [],
        points_translations: subService.points_translations || { en: [], it: [], fr: [] },
        is_expanded: subService.is_expanded,
        sort_order: subService.sort_order,
        status: subService.status,
        source_language: ''
    })
    subServiceForm.reset()
    // Ensure translations are properly initialized
    subServiceForm.title_translations = subService.title_translations || { en: '', it: '', fr: '' }
    subServiceForm.points_translations = subService.points_translations || { en: [], it: [], fr: [] }
    showSubServiceModal.value = true
}

// Translation handling
async function handleTranslation(translationData) {
    try {
        // Use the main English input as source if no source text is provided
        let sourceText = translationData.sourceText
        let sourceLanguage = translationData.sourceLanguage || 'en'
        
        if (!sourceText && translationData.field_name === 'title') {
            sourceText = subServiceForm.title
            sourceLanguage = 'en'
        } else if (!sourceText && translationData.field_name === 'points') {
            sourceText = subServiceForm.points
            sourceLanguage = 'en'
        }
        
        if (!sourceText || (Array.isArray(sourceText) && sourceText.length === 0)) {
            alert('Please enter content in the English field before auto-translating.')
            return
        }
        
        const response = await fetch('/api/translate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                text: sourceText,
                source_language: sourceLanguage,
                field_name: translationData.field_name
            })
        })
        
        const result = await response.json()
        
        if (result.success) {
            // Update the form with translations
            if (translationData.field_name === 'title') {
                subServiceForm.title_translations = result.translations
            } else if (translationData.field_name === 'points') {
                subServiceForm.points_translations = result.translations
            }
        } else {
            console.error('Translation failed:', result.message)
            alert('Translation failed: ' + result.message)
        }
    } catch (error) {
        console.error('Translation error:', error)
        alert('Translation error: ' + error.message)
    }
}

function submitSubServiceForm() {
    console.log('Submitting sub-service form:', subServiceForm.data())
    
    const options = {
        onSuccess: () => {
            console.log('Sub-service form submitted successfully')
            subServiceForm.reset()
            showSubServiceModal.value = false
        },
        onError: (errors) => {
            console.log('Form errors:', errors)
        },
        preserveScroll: true,
    }

    if (isEditingSubService.value && editingSubService.value) {
        console.log('Updating sub-service:', editingSubService.value.id)
        subServiceForm.put(route('sub-services.update', editingSubService.value.id), options)
    } else {
        console.log('Creating new sub-service')
        subServiceForm.post(route('sub-services.store'), options)
    }
}

// Point management functions
function addPoint() {
    subServiceForm.points.push('')
}

function removePoint(index) {
    subServiceForm.points.splice(index, 1)
}

function updatePoint(index, value) {
    subServiceForm.points[index] = value
}

// Action functions
function deleteSubService(subService) {
    if (confirm(`Are you sure you want to delete "${subService.title}"?`)) {
        router.delete(route('sub-services.destroy', subService.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Sub-service deleted ✅')
            }
        })
    }
}

function toggleSubServiceStatus(subService) {
    router.patch(route('sub-services.toggleStatus', subService.id))
}

function goBackToServices() {
    router.visit(route('services.index'))
}

// Accordion functionality
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

function expandAll() {
    props.subServices.forEach(subService => {
        expandedTitles.value.add(subService.id)
    })
}

function collapseAll() {
    expandedTitles.value.clear()
}

// Initialize expanded titles based on is_expanded property
props.subServices.forEach(subService => {
    if (subService.is_expanded) {
        expandedTitles.value.add(subService.id)
    }
})
</script>

<template>
  <Head :title="`Sub-Services - ${service.name}`" />

  <AuthenticatedLayout>
    <template #header>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Sub-Services: {{ service.name }}
                </h2>
                <p class="text-muted mb-0">Manage titles and points for this service</p>
            </div>
            <button class="btn btn-outline-secondary" @click="goBackToServices">
                <i class="fas fa-arrow-left me-1"></i> Back to Services
            </button>
        </div>
    </template>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Search and Add Button -->
            <div class="d-flex justify-content-between mb-4">
                <input type="text" v-model="search" class="form-control w-50" placeholder="Search sub-services..." />
                <button class="btn btn-primary" @click="openAddSubServiceModal">
                    <i class="fas fa-plus me-1"></i> Add Sub-Service
                </button>
            </div>

            <!-- Sub-Services Accordion Display -->
            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Sub-Services (Titles & Points)</h4>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-secondary" @click="expandAll" title="Expand All">
                            <i class="fas fa-expand-arrows-alt me-1"></i> Expand All
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" @click="collapseAll" title="Collapse All">
                            <i class="fas fa-compress-arrows-alt me-1"></i> Collapse All
                        </button>
                    </div>
                </div>

                <div v-if="filteredSubServices.length > 0" class="service-details__faq">
                    <div class="accrodion-grp faq-one-accrodion" data-grp-name="faq-one-accrodion">
                        <div 
                            v-for="(subService, index) in filteredSubServices" 
                            :key="subService.id"
                            class="accrodion"
                            :class="{ 
                                'active': isTitleExpanded(subService.id),
                                'last-chiled': index === filteredSubServices.length - 1
                            }"
                        >
                            <div class="accrodion-title" @click="toggleTitle(subService.id)">
                                <h4>{{ getTranslatedText(subService.title_translations, subService.title) }}</h4>
                                <div class="accrodion-actions">
                                    <button class="btn btn-sm btn-warning me-1" @click.stop="openEditSubServiceModal(subService)" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm" :class="subService.status === 'active' ? 'btn-secondary' : 'btn-success'" @click.stop="toggleSubServiceStatus(subService)" :title="subService.status === 'active' ? 'Deactivate' : 'Activate'">
                                        <i :class="subService.status === 'active' ? 'fas fa-pause' : 'fas fa-play'"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ms-1" @click.stop="deleteSubService(subService)" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div 
                                class="accrodion-content" 
                                :style="isTitleExpanded(subService.id) ? '' : 'display: none'"
                            >
                                <div class="inner">
                                    <ul v-if="getTranslatedArray(subService.points_translations, subService.points).length > 0">
                                        <li v-for="(point, pointIndex) in getTranslatedArray(subService.points_translations, subService.points)" :key="pointIndex">
                                            {{ point }}
                                        </li>
                                    </ul>
                                    <div v-else class="text-muted">
                                        No points added yet.
                                    </div>
                                </div>
                                <!-- /.inner -->
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center text-muted p-4">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <h5>No sub-services found</h5>
                    <p>Click "Add Sub-Service" to create your first sub-service for this service.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sub-Service Modal -->
    <div class="modal fade" tabindex="-1" :class="{ show: showSubServiceModal }" style="display: block" v-if="showSubServiceModal">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <form @submit.prevent="submitSubServiceForm">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ isEditingSubService ? 'Edit Sub-Service' : 'Add Sub-Service' }}</h5>
                        <button type="button" class="btn-close" @click="showSubServiceModal = false"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="mb-3">
                            <label class="form-label">Service</label>
                            <input type="text" class="form-control" :value="service.name" readonly />
                            <small class="text-muted">This sub-service will be added to: {{ service.name }}</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title (English) *</label>
                            <input v-model="subServiceForm.title" type="text" class="form-control" required />
                            <div v-if="subServiceForm.errors.title" class="text-danger small">{{ subServiceForm.errors.title }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Multilingual Titles</label>
                            <MultilingualInput
                                v-model="subServiceForm.title_translations"
                                field-name="title"
                                label="Title"
                                type="text"
                                :show-auto-translate="true"
                                @translate="handleTranslation"
                            />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Points (English)</label>
                            <div class="points-container">
                                <div v-for="(point, index) in subServiceForm.points" :key="index" class="point-item d-flex mb-2">
                                    <input 
                                        v-model="subServiceForm.points[index]" 
                                        type="text" 
                                        class="form-control me-2" 
                                        :placeholder="`Point ${index + 1}`"
                                    />
                                    <button type="button" class="btn btn-sm btn-danger" @click="removePoint(index)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <button type="button" class="btn btn-sm btn-success" @click="addPoint">
                                    <i class="fas fa-plus me-1"></i> Add Point
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Multilingual Points</label>
                            <MultilingualArrayInput
                                v-model="subServiceForm.points_translations"
                                field-name="points"
                                label="Point"
                                :show-auto-translate="true"
                                @translate="handleTranslation"
                            />
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input v-model="subServiceForm.sort_order" type="number" class="form-control" min="0" />
                                    <div v-if="subServiceForm.errors.sort_order" class="text-danger small">{{ subServiceForm.errors.sort_order }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-block">Expanded by Default</label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" :value="true" v-model="subServiceForm.is_expanded" /> Yes
                                        </label>
                                        <label>
                                            <input type="radio" :value="false" v-model="subServiceForm.is_expanded" /> No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label d-block">Status</label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" value="active" v-model="subServiceForm.status" /> Active
                                        </label>
                                        <label>
                                            <input type="radio" value="inactive" v-model="subServiceForm.status" /> Inactive
                                        </label>
                                    </div>
                                    <div v-if="subServiceForm.errors.status" class="text-danger small">{{ subServiceForm.errors.status }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showSubServiceModal = false">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success" :disabled="subServiceForm.processing">
                            {{ isEditingSubService ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div v-if="showSubServiceModal" class="modal-backdrop fade show" @click="showSubServiceModal = false"></div>

  </AuthenticatedLayout>
</template>

<style scoped>
.points-container {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 1rem;
    background-color: #f8f9fa;
}

.point-item {
    align-items: center;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.table-responsive {
    border-radius: 6px;
}

.badge {
    font-size: 0.75em;
}

/* Accordion Actions Styling */
.accrodion-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.accrodion-title h4 {
    margin: 0;
    flex: 1;
}

.accrodion-actions {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.accrodion-actions .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

/* Ensure accordion styling matches template */
.accrodion-title {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    transition: background-color 0.3s ease;
}

.accrodion-title:hover {
    background-color: #f8f9fa;
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
}
</style>
