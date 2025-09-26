<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import '../../../css/admin.css'

const props = defineProps({
  setting: Object
})

const form = useForm({
  site_name: props.setting.site_name || '',
  logo: null,
  phone_one: props.setting.phone_one || '',
  phone_two: props.setting.phone_two || '',
  email_one: props.setting.email_one || '',
  email_two: props.setting.email_two || '',
  address_one: props.setting.address_one || '',
  address_two: props.setting.address_two || '',
  footer_description: props.setting.footer_description || ''
})

const previewLogo = ref(props.setting.logo ? `/storage/${props.setting.logo}` : null)

function handleFileUpload(e) {
  const file = e.target.files[0]
  form.logo = file
  if (file) {
    previewLogo.value = URL.createObjectURL(file)
  }
}

function submitForm() {
  form.post(route('settings.update', props.setting.id), {
    forceFormData: true,
    preserveScroll: true,
  })
}
</script>

<template>
  <Head title="Website Settings" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold text-gray-800">Website Settings</h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
          <form @submit.prevent="submitForm">
            <div class="mb-3">
              <label class="form-label">Website Name</label>
              <input v-model="form.site_name" type="text" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label">Logo</label>
              <div v-if="previewLogo" class="mb-2">
                <img :src="previewLogo" alt="Logo Preview" width="120" class="rounded border" />
              </div>
              <input type="file" class="form-control" accept="image/*" @change="handleFileUpload" />
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Phone 1</label>
                <input v-model="form.phone_one" type="text" class="form-control" />
              </div>
              <div class="col-md-6 mb-3">
                <label>Phone 2</label>
                <input v-model="form.phone_two" type="text" class="form-control" />
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Email 1</label>
                <input v-model="form.email_one" type="email" class="form-control" />
              </div>
              <div class="col-md-6 mb-3">
                <label>Email 2</label>
                <input v-model="form.email_two" type="email" class="form-control" />
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Address 1</label>
                <input v-model="form.address_one" type="text" class="form-control" />
              </div>
              <div class="col-md-6 mb-3">
                <label>Address 2</label>
                <input v-model="form.address_two" type="text" class="form-control" />
              </div>
            </div>

            <div class="mb-3">
              <label>Footer Description</label>
              <textarea v-model="form.footer_description" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success" :disabled="form.processing">
              Save Settings
            </button>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
