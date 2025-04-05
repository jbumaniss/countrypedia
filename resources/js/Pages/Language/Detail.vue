<template>
  <ion-page>
    <AppLayout title="Country Details">
      <div class="container mx-auto p-4" v-if="language">
        <h2>{{ language.name }}</h2>

        <CountryList
            v-if="language && language.countries && language.countries?.length > 0"
            header-title="Countries"
            :countries="language.countries"
        />

      </div>
      <div class="container mx-auto p-4" v-else>
        <p>Waiting...</p>

      </div>
    </AppLayout>
  </ion-page>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import CountryList from "@/Components/CountryList.vue";
import LanguageList from "@/Components/LanguageList.vue";

export default {
  name: 'CountryDetails',
  components: {
    LanguageList,
    CountryList,
    AppLayout
  },
  props: {
    language: {
      type: null,
      required: true
    }
  },
};
</script>
