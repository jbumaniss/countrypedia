<template>
  <ion-page>
    <AppLayout title="Country Details">
      <ion-card>
        <ion-card-content>
          <ion-list v-if="language">
            <ion-list-header lines="none" class="font-bold text-xl">
              <ion-label>
                {{ language.name }}
              </ion-label>
            </ion-list-header>
          </ion-list>
        </ion-card-content>
      </ion-card>

      <CountryList
          v-if="language && language.countries && language.countries?.length > 0"
          header-title="Countries"
          :countries="language.countries"
      />

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
