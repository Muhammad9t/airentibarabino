<script setup>

    import { ref, computed } from 'vue'
    import { Head, useForm } from '@inertiajs/vue3'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import '../../../css/admin.css'
    import { router } from '@inertiajs/vue3'
    import { QuillEditor } from '@vueup/vue-quill'
    import '@vueup/vue-quill/dist/vue-quill.snow.css'


    const showModal = ref(false)
    const isEditing = ref(false)
    const editingService = ref(null)
    const editorKey = ref(0)

    const props = defineProps({
        services: {
            type: Array,
            default: () => []
        }
    })

    const form = useForm({
        name: '',
        description: '',
        status: ''
    })

    const search = ref('')
    const filteredServices = computed(() =>
        props.services.filter(
            (s) =>
            s.name.toLowerCase().includes(search.value.toLowerCase()) ||
            s.description?.toLowerCase().includes(search.value.toLowerCase())
        )
    )

    // function openAddModal() {
    //     isEditing.value = false
    //     editingService.value = null
    //     form.defaults({
    //         name: '',
    //         description: '',
    //         status: 'active'
    //     })
    //     form.reset()
    //     showModal.value = true
    // }

    // function openEditModal(service) {
    //     isEditing.value = true
    //     editingService.value = service
    //     form.defaults({
    //         name: service.name,
    //         description: service.description,
    //         status: service.status
    //     })
    //     form.reset()
    //     showModal.value = true
    // }

    function openAddModal() {
        isEditing.value = false
        editingService.value = null
        form.defaults({
            name: '',
            description: '',
            status: 'active'
        })
        form.reset()
        editorKey.value++
        showModal.value = true
    }

    function openEditModal(service) {
        isEditing.value = true
        editingService.value = service
        form.defaults({
            name: service.name,
            description: service.description,
            status: service.status
        })
        form.reset()
        editorKey.value++
        showModal.value = true
    }

    function submitForm() {
        const options = {
            onSuccess: () => {
            form.reset()
                showModal.value = false
            },
            preserveScroll: true,
        }

        if (isEditing.value && editingService.value) {
            form.put(route('services.update', editingService.value.slug), options)
        } else {
            form.post(route('services.store'), options)
        }
    }

    function deleteService(service) {
        if (confirm(`Are you sure you want to delete "${service.name}"?`)) {
            form.delete(route('services.destroy', service.slug), {
                preserveScroll: true,
                onSuccess: () => {
                    console.log('Service deleted ✅')
                }
            })
        }
    }

    function toggleStatus(service) {
        router.patch(route('services.toggleStatus', service.slug))
    }

</script>

<template>
  <Head title="Services" />

  <AuthenticatedLayout>
    <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">Services</h2>
    </template>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="d-flex justify-content-between mb-3">
                    <input type="text" v-model="search" class="form-control w-50" placeholder="Search services..." />
                    <button class="btn btn-primary" @click="openAddModal">Add Service</button>
                </div>

                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(service, index) in filteredServices" :key="service.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ service.name }}</td>
                            <td v-html="service.description"></td>
                            <td>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium border"
                                    :class="service.status === 'active'
                                        ? 'bg-blue-100 text-blue-600 border-blue-600'
                                        : 'bg-red-100 text-red-600 border-red-600'"
                                    >
                                    {{ service.status === 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning me-2" @click="openEditModal(service)">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger me-2" @click="deleteService(service)">
                                    Delete
                                </button>
                                <button class="btn btn-sm" :class="service.status === 'active' ? 'btn-secondary' : 'btn-success'" @click="toggleStatus(service)">
                                    {{ service.status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </td>
                        </tr>
                        <tr v-if="filteredServices.length === 0">
                            <td colspan="4" class="text-center text-muted">
                                No services found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" :class="{ show: showModal }" style="display: block" v-if="showModal" >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form @submit.prevent="submitForm">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ isEditing ? 'Edit Service' : 'Add Service' }}</h5>
                        <button type="button" class="btn-close" @click="showModal = false" ></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input v-model="form.name" type="text" class="form-control" required />
                        </div>

                        <!-- <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea v-model="form.description" rows="3" class="form-control" required></textarea>
                        </div> -->

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <QuillEditor
                                v-model:content="form.description"
                                content-type="html"
                                theme="snow"
                                style="height: 200px;"
                                :key="editorKey"
                            />
                            <div v-if="form.errors.description" class="text-danger small">
                                {{ form.errors.description }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Status</label>
                            <div>
                                <label class="me-3">
                                    <input type="radio" value="active" v-model="form.status" /> Active
                                </label>
                                <label>
                                    <input type="radio" value="inactive" v-model="form.status" /> Inactive
                                </label>
                            </div>
                            <div v-if="form.errors.status" class="text-danger small">{{ form.errors.status }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showModal = false">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success" :disabled="form.processing">
                            {{ isEditing ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div v-if="showModal" class="modal-backdrop fade show" @click="showModal = false" ></div>
  </AuthenticatedLayout>
</template>
