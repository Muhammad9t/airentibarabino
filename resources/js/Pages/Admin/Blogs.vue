<script setup>

    import { ref, computed } from 'vue'
    import { Head, useForm } from '@inertiajs/vue3'
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import '../../../css/admin.css'

    const showModal = ref(false);
    const isEditing = ref(false);
    const editingBlog = ref(null);

    const props = defineProps({
    blogs: {
        type: Array,
        default: () => []
    }
    })

    const form = useForm({
        title: '',
        description: '',
        image: null
    })

    const search = ref('')
    const filteredBlogs = computed(() =>
        (props.blogs || []).filter(
            (b) => b.title.toLowerCase().includes(search.value.toLowerCase()) || b.description.toLowerCase().includes(search.value.toLowerCase())
        )
    )

    const previewImage = ref(null)

    function handleFileUpload(e) {
        const file = e.target.files[0]
        form.image = file
        if (file) {
            previewImage.value = URL.createObjectURL(file)
        }
    }

    function openAddModal() {
        isEditing.value = false
        editingBlog.value = null
        form.reset()
        showModal.value = true
    }

    function openEditModal(blog) {
        isEditing.value = true
        editingBlog.value = blog

        form.defaults({
            title: blog.title,
            description: blog.description,
            image: null,
        })
        form.reset()

        showModal.value = true
    }


    function submitForm() {
        const options = {
            forceFormData: true,
            onSuccess: () => {
                form.reset()
                previewImage.value = null
                showModal.value = false
            },
            preserveScroll: true,
        }

        if (isEditing.value && editingBlog.value) {
            form.transform((data) => ({ ...data, _method: 'PUT', }))
            form.post(route('blogs.update', editingBlog.value.id), options)
        } else {
            form.post(route('blogs.store'), options)
        }
    }

    function deleteBlog(blog) {
        if (confirm(`Are you sure you want to delete "${blog.title}" blog?`)) {
            form.delete(route('blogs.destroy', blog.id), {
                preserveScroll: true,
                onSuccess: () => {
                    const index = props.blogs.findIndex(b => b.id === blog.id)
                    if (index !== -1) {
                        props.blogs.splice(index, 1)
                    }
                    alert('Blog deleted!')
                }
            })
        }
    }


</script>

<template>
    <Head title="Blogs" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Blogs</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="d-flex justify-content-between mb-3">
                        <input type="text" v-model="search" class="form-control w-50" placeholder="Search blogs..." />
                        <button class="btn btn-primary" @click="openAddModal"> Add Blog </button>
                    </div>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(blog, index) in filteredBlogs" :key="blog.id">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    <img :src="blog.image" alt="Blog Image" width="80" class="rounded" />
                                </td>
                                <td>{{ blog.title }}</td>
                                <td>{{ blog.description }}</td>
                                <td>{{ new Date(blog.created_at).toLocaleDateString('en-GB').replace(/\//g, '-') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning me-2" @click="openEditModal(blog)">Edit</button>
                                    <button class="btn btn-sm btn-danger" @click.prevent="deleteBlog(blog)" >Delete</button>
                                </td>
                            </tr>
                            <tr v-if="filteredBlogs.length === 0">
                                <td colspan="5" class="text-center text-muted">
                                    No blogs found
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" :class="{ show: showModal }" style="display: block" v-if="showModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="submitForm">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ isEditing ? 'Edit Blog' : 'Add Blog' }}</h5>
                            <button type="button" class="btn-close" @click="showModal = false"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input v-model="form.title" type="text" class="form-control" required />
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea v-model="form.description" rows="3" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image</label>

                                <div v-if="previewImage" class="mb-2">
                                    <img :src="previewImage" alt="Preview Image" width="120" class="rounded border" />
                                </div>

                                <div v-else-if="isEditing && editingBlog?.image" class="mb-2">
                                    <img :src="editingBlog.image" alt="Current Blog Image" width="120" class="rounded border" />
                                </div>

                                <input
                                    type="file"
                                    class="form-control"
                                    accept="image/*"
                                    @change="handleFileUpload"
                                    :required="!isEditing"
                                />
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="showModal = false; previewImage = null">Cancel</button>
                            <button type="submit" class="btn btn-success" :disabled="form.processing">
                                {{ isEditing ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="modal-backdrop fade show" @click="showModal = false"></div>
    </AuthenticatedLayout>
</template>
