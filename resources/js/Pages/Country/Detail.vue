<template>
  <ion-page>
    <AppLayout title="Country Details">
      <div class="container mx-auto p-4" v-if="country">
        <h2>{{ country.common_name }}</h2>
        <p><strong>Official Name:</strong> {{ country.official_name }}</p>
        <p><strong>Country Code:</strong> {{ country.country_code }}</p>
        <p><strong>Population:</strong> {{ country.population }}</p>
        <p><strong>Population rank:</strong> {{ country.population_rank }}</p>
        <p><strong>Flag:</strong> <span v-html="country.flag"></span></p>
        <p><strong>Area:</strong> {{ country.area }} km²</p>
        <ion-button @click="toggleFavorite" color="primary">
          <ion-icon slot="start" :icon="isFavorite ? heart : heartOutline"></ion-icon>
          {{ isFavorite ? 'Unmark Favorite' : 'Mark as Favorite' }}
        </ion-button>

        <CountryList
            v-if="country && country.neighbours && country.neighbours?.length > 0"
            header-title="Neighboring Countries"
            :countries="country.neighbours"
        />

        <LanguageList
            v-if="country && country.languages && country.languages?.length > 0"
            header-title="Languages"
            :languages="country.languages"
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
import { heart, heartOutline } from 'ionicons/icons';
import { getFavorites, addFavorite, removeFavorite } from '@/utils/favorites.js';
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
  created() {
    console.log(this.country);
  },
  computed: {
    isFavorite() {
      return this.localFavorite;
    }
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
    this.localFavorite = getFavorites().some(fav => fav?.id === this.country.id);
  }
};
</script>
