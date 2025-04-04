<template>
  <ion-page>
    <AppLayout title="Country Details">
      <div class="container mx-auto p-4">
        <h2>{{ country.common_name }}</h2>
        <p><strong>Official Name:</strong> {{ country.official_name }}</p>
        <p><strong>Country Code:</strong> {{ country.country_code }}</p>
        <p><strong>Population:</strong> {{ country.population }}</p>
        <p><strong>Flag:</strong> <span v-html="country.flag"></span></p>
        <p><strong>Area:</strong> {{ country.area }} km²</p>
        <div>
          <h3>Neighboring Countries</h3>
          <ion-list>
            <ion-item
                v-for="neighbor in country.neighbors"
                :key="neighbor.id"
                :href="`/country/${neighbor.id}`">
              <ion-label>{{ neighbor.common_name }}</ion-label>
            </ion-item>
          </ion-list>
        </div>
        <div>
          <h3>Languages</h3>
          <ion-list>
            <ion-item
                v-for="language in country.languages"
                :key="language.id"
                :href="`/language/${language.id}`">
              <ion-label>{{ language.name }}</ion-label>
            </ion-item>
          </ion-list>
        </div>
        <ion-button @click="toggleFavorite" color="primary">
          <ion-icon slot="start" :icon="country.is_favorite ? 'heart' : 'heart-outline'"></ion-icon>
          {{ country.is_favorite ? 'Unmark Favorite' : 'Mark as Favorite' }}
        </ion-button>
      </div>
    </AppLayout>
  </ion-page>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
export default {
  name: 'CountryDetails',
  components: {
    AppLayout
  },
  props: {
    country: {
      type: Object,
      required: true
    }
  },
  methods: {
    toggleFavorite() {
      this.country.is_favorite = !this.country.is_favorite;
    }
  }
};
</script>
