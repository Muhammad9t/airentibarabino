<script setup>
import FrontEndLayout from '@/Layouts/FrontEndLayout.vue';
import ServicesHierarchy from '@/Components/ServicesHierarchy.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const service = computed(() => page.props.service);

</script>

<template>
  <FrontEndLayout>
    <section class="services-section py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <ServicesHierarchy :services="[service]" />
          </div>
        </div>
      </div>
    </section>
  </FrontEndLayout>
</template>

<style scoped>
.services-section {
  background-color: #f8f9fa;
  min-height: 60vh;
}
</style>
