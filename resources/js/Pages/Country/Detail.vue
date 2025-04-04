<template>
  <ion-page>
    <AppLayout title="Country Details">
      <div class="container mx-auto p-4" v-if="country">
        <h2>{{ country.common_name }}</h2>
        <p><strong>Official Name:</strong> {{ country.official_name }}</p>
        <p><strong>Country Code:</strong> {{ country.country_code }}</p>
        <p><strong>Population:</strong> {{ country.population }}</p>
        <p><strong>Flag:</strong> <span v-html="country.flag"></span></p>
        <p><strong>Area:</strong> {{ country.area }} km²</p>
        <ion-button @click="toggleFavorite" color="primary">
          <ion-icon slot="start" :icon="isFavorite ? heart : heartOutline"></ion-icon>
          {{ isFavorite ? 'Unmark Favorite' : 'Mark as Favorite' }}
        </ion-button>
      </div>
      <div class="container mx-auto p-4" v-else>
        <p>Waiting...</p>

      </div>
    </AppLayout>
  </ion-page>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import { heart, heartOutline } from 'ionicons/icons';
import { getFavorites, addFavorite, removeFavorite } from '../../utils/favorites';

export default {
  name: 'CountryDetails',
  components: {
    AppLayout
  },
  props: {
    country: {
      type: null,
      required: true
    }
  },
  data() {
    return {
      heart,
      heartOutline,
      localFavorite: false
    };
  },
  computed: {
    isFavorite() {
      const favorites = getFavorites();
      return favorites.some(fav => fav?.id === this?.country?.id) || this.localFavorite;
    },
  },
  methods: {
    toggleFavorite() {
      if (this.isFavorite) {
        removeFavorite(this.country.id);
        this.localFavorite = false;
      } else {
        addFavorite(this.country);
        this.localFavorite = true;
      }
    }
  },
  mounted() {
    this.localFavorite = this.isFavorite;
  }
};
</script>
