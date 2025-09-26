<script setup>
import FrontEndLayout from '@/Layouts/FrontEndLayout.vue';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const service = computed(() => page.props.service);

</script>

<template>
  <FrontEndLayout>

    <section>
      <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="service-details__faq">
                    <div class="accrodion-grp faq-one-accrodion" data-grp-name="faq-one-accrodion">
                        <div class="accrodion active">
                        <div class="accrodion-title">
                            <h4>{{ service.name }}</h4>
                        </div>
                        <div class="accrodion-content" style="">
                                <div class="inner">
                                    <ul>
                                        <li >
                                            <p v-html="service.description"></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </section>
  </FrontEndLayout>
</template>
