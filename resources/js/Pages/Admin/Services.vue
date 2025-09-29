<script setup>
import { ref, computed } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import MultilingualInput from '@/Components/Admin/MultilingualInput.vue'
import '../../../css/admin.css'
import { router } from '@inertiajs/vue3'
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'

// Modal states
const showServiceModal = ref(false)
const isEditingService = ref(false)
const editingService = ref(null)
const editorKey = ref(0)

const props = defineProps({
    services: {
        type: Array,
        default: () => []
    }
})

// Service form
const serviceForm = useForm({
    name: '',
    name_translations: { en: '', it: '', fr: '' },
    slug: '',
    description: '',
    description_translations: { en: '', it: '', fr: '' },
    menu_order: 0,
    status: 'active',
    source_language: ''
})


// Search functionality
const search = ref('')
const filteredServices = computed(() =>
    props.services.filter(service =>
        service.name.toLowerCase().includes(search.value.toLowerCase()) ||
        service.description?.toLowerCase().includes(search.value.toLowerCase())
    )
)


// Service modal functions
function openAddServiceModal() {
    isEditingService.value = false
    editingService.value = null
    serviceForm.defaults({
        name: '',
        name_translations: { en: '', it: '', fr: '' },
        slug: '',
        description: '',
        description_translations: { en: '', it: '', fr: '' },
        menu_order: 0,
        status: 'active',
        source_language: ''
    })
    serviceForm.reset()
    // Ensure translations are properly initialized
    serviceForm.name_translations = { en: '', it: '', fr: '' }
    serviceForm.description_translations = { en: '', it: '', fr: '' }
    editorKey.value++
    showServiceModal.value = true
}

function openEditServiceModal(service) {
    isEditingService.value = true
    editingService.value = service
    serviceForm.defaults({
        name: service.name,
        name_translations: service.name_translations || { en: '', it: '', fr: '' },
        slug: service.slug,
        description: service.description,
        description_translations: service.description_translations || { en: '', it: '', fr: '' },
        menu_order: service.menu_order,
        status: service.status,
        source_language: ''
    })
    serviceForm.reset()
    // Ensure translations are properly initialized
    serviceForm.name_translations = service.name_translations || { en: service.name || '', it: '', fr: '' }
    serviceForm.description_translations = service.description_translations || { en: service.description || '', it: '', fr: '' }
    editorKey.value++
    showServiceModal.value = true
}

function submitServiceForm() {
    const options = {
        onSuccess: () => {
            serviceForm.reset()
            showServiceModal.value = false
        },
        preserveScroll: true,
    }

    if (isEditingService.value && editingService.value) {
        serviceForm.put(route('services.update', editingService.value.slug), options)
    } else {
        serviceForm.post(route('services.store'), options)
    }
}


// Action functions
function deleteService(service) {
    if (confirm(`Are you sure you want to delete "${service.name}"? This will also delete all its sub-services.`)) {
        router.delete(route('services.destroy', service.slug), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Service deleted ✅')
            }
        })
    }
}

function toggleServiceStatus(service) {
    router.patch(route('services.toggleStatus', service.slug))
}

function viewService(service) {
    router.visit(route('services.sub-services', service.slug))
}


function truncateDescription(text, wordLimit = 25) {
    if (!text) return ''
    const words = text.replace(/<\/?p>/g, '').split(/\s+/)
    if (words.length <= wordLimit) return words.join(' ')
    return words.slice(0, wordLimit).join(' ')
}

// Generate slug from name
function generateSlug() {
    if (serviceForm.name) {
        serviceForm.slug = serviceForm.name
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-')
    }
}

// Translation functions
function handleTranslation(translationData) {
    // Use the main English input as source if no source text is provided
    let sourceText = translationData.sourceText
    let sourceLanguage = translationData.sourceLanguage || 'en'
    
    if (!sourceText && translationData.fieldName === 'name') {
        sourceText = serviceForm.name
        sourceLanguage = 'en'
    } else if (!sourceText && translationData.fieldName === 'description') {
        sourceText = serviceForm.description
        sourceLanguage = 'en'
    }
    
    if (!sourceText || sourceText.trim() === '') {
        alert('Please enter content in the English field before auto-translating.')
        return
    }
    
    // Make API call to translate
    fetch('/api/translate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            text: sourceText,
            source_language: sourceLanguage,
            field_name: translationData.fieldName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the form with translations
            if (translationData.fieldName === 'name') {
                serviceForm.name_translations = data.translations
            } else if (translationData.fieldName === 'description') {
                serviceForm.description_translations = data.translations
            }
        } else {
            alert('Translation failed: ' + (data.message || 'Unknown error'))
        }
    })
    .catch(error => {
        console.error('Translation error:', error)
        alert('Translation failed. Please try again.')
    })
}
</script>

<template>
  <Head title="Services Management" />

  <AuthenticatedLayout>
    <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Services Management</h2>
    </template>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Search and Add Button -->
            <div class="d-flex justify-content-between mb-4">
                <input type="text" v-model="search" class="form-control w-50" placeholder="Search services..." />
                <button class="btn btn-primary" @click="openAddServiceModal">
                    <i class="fas fa-plus me-1"></i> Add Service
                </button>
            </div>

            <!-- Main Services Table -->
            <div class="bg-white shadow-sm sm:rounded-lg p-4 mb-4">
                <h4 class="mb-3">Main Services</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Menu Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(service, index) in filteredServices" :key="service.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ service.name }}</td>
                                <td><code>{{ service.slug }}</code></td>
                                <td>
                                    <span v-html="truncateDescription(service.description)"></span>
                                </td>
                                <td>{{ service.menu_order }}</td>
                                <td>
                                    <span class="badge" :class="service.status === 'active' ? 'badge-success' : 'badge-danger'">
                                        {{ service.status === 'active' ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" @click="viewService(service)" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" @click="openEditServiceModal(service)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm" :class="service.status === 'active' ? 'btn-secondary' : 'btn-success'" @click="toggleServiceStatus(service)" :title="service.status === 'active' ? 'Deactivate' : 'Activate'">
                                            <i :class="service.status === 'active' ? 'fas fa-pause' : 'fas fa-play'"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" @click="deleteService(service)" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="filteredServices.length === 0">
                                <td colspan="7" class="text-center text-muted">
                                    No services found
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Service Modal -->
    <div class="modal fade" tabindex="-1" :class="{ show: showServiceModal }" style="display: block" v-if="showServiceModal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form @submit.prevent="submitServiceForm">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ isEditingService ? 'Edit Service' : 'Add Service' }}</h5>
                        <button type="button" class="btn-close" @click="showServiceModal = false"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <div class="mb-3">
                            <label class="form-label">Service Name (English) *</label>
                            <input v-model="serviceForm.name" type="text" class="form-control" required @input="generateSlug" />
                            <div v-if="serviceForm.errors.name" class="text-danger small">{{ serviceForm.errors.name }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Multilingual Names</label>
                            <MultilingualInput
                                v-model="serviceForm.name_translations"
                                field-name="name"
                                label="Service Name"
                                type="text"
                                :show-auto-translate="true"
                                @translate="handleTranslation"
                            />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug *</label>
                            <input v-model="serviceForm.slug" type="text" class="form-control" required />
                            <div v-if="serviceForm.errors.slug" class="text-danger small">{{ serviceForm.errors.slug }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description (English)</label>
                            <textarea v-model="serviceForm.description" class="form-control" rows="3"></textarea>
                            <div v-if="serviceForm.errors.description" class="text-danger small">
                                {{ serviceForm.errors.description }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Multilingual Descriptions</label>
                            <MultilingualInput
                                v-model="serviceForm.description_translations"
                                field-name="description"
                                label="Description"
                                type="textarea"
                                :rows="4"
                                :show-auto-translate="true"
                                @translate="handleTranslation"
                            />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Menu Order</label>
                                    <input v-model="serviceForm.menu_order" type="number" class="form-control" min="0" />
                                    <div v-if="serviceForm.errors.menu_order" class="text-danger small">{{ serviceForm.errors.menu_order }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label d-block">Status</label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" value="active" v-model="serviceForm.status" /> Active
                                        </label>
                                        <label>
                                            <input type="radio" value="inactive" v-model="serviceForm.status" /> Inactive
                                        </label>
                                    </div>
                                    <div v-if="serviceForm.errors.status" class="text-danger small">{{ serviceForm.errors.status }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showServiceModal = false">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success" :disabled="serviceForm.processing">
                            {{ isEditingService ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div v-if="showServiceModal" class="modal-backdrop fade show" @click="showServiceModal = false"></div>


  </AuthenticatedLayout>
</template>

<style scoped>
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

.badge-success {
    background-color: #28a745;
}

.badge-danger {
    background-color: #dc3545;
}

.text-muted {
    color: #6c757d !important;
}

code {
    background-color: #f8f9fa;
    padding: 2px 4px;
    border-radius: 3px;
    font-size: 0.875em;
}

/* Modal scrolling fixes */
.modal {
    z-index: 1055;
}

.modal-dialog-scrollable .modal-body {
    overflow-y: auto;
}

.modal-backdrop {
    z-index: 1050;
}

/* Ensure modal is properly positioned */
.modal.show {
    display: block !important;
}

/* Custom scrollbar for modal body */
.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>