<script setup>

    import { ref, computed } from 'vue'
    import { Head, useForm } from '@inertiajs/vue3'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import '../../../css/admin.css'

    const showModal = ref(false)
    const isEditing = ref(false)
    const editingService = ref(null)

    const props = defineProps({
        services: {
            type: Array,
            default: () => []
        }
    })

    const form = useForm({
        name: '',
        description: ''
    })

    const search = ref('')
    const filteredServices = computed(() =>
        props.services.filter(
            (s) =>
            s.name.toLowerCase().includes(search.value.toLowerCase()) ||
            s.description?.toLowerCase().includes(search.value.toLowerCase())
        )
    )

    function openAddModal() {
        isEditing.value = false
        editingService.value = null
        form.reset()
        showModal.value = true
    }

    function openEditModal(service) {
        isEditing.value = true
        editingService.value = service
        form.defaults({
            name: service.name,
            description: service.description
        })
        form.reset()
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
            form.put(route('services.update', editingService.value.id), options)
        } else {
            form.post(route('services.store'), options)
        }
    }

    function deleteService(service) {
    if (confirm(`Are you sure you want to delete "${service.name}"?`)) {
        form.delete(route('services.destroy', service.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Service deleted ✅')
            }
        })
    }
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(service, index) in filteredServices" :key="service.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ service.name }}</td>
                            <td>{{ service.description }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning me-2" @click="openEditModal(service)">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger" @click="deleteService(service)">
                                    Delete
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
        <div class="modal-dialog">
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
                            <div v-if="form.errors.name" class="text-danger small">
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea v-model="form.description" rows="3" class="form-control"></textarea>
                            <div v-if="form.errors.description" class="text-danger small">
                                {{ form.errors.description }}
                            </div>
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
