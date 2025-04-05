<template>
  <ion-page>
    <AppLayout title="Country Details">
      <ion-card>
        <ion-card-content>
        <ion-list v-if="country">
          <ion-list-header lines="inset" class="font-bold text-xl">
            <ion-label>
              {{ country.common_name }}
            </ion-label>
          </ion-list-header>
          <ion-item>
            <ion-label>
              Official Name: {{ country.official_name }}
            </ion-label>
          </ion-item>
          <ion-item>
            <ion-label>
              Country Code: {{ country.country_code }}
            </ion-label>
          </ion-item>
          <ion-item>
            <ion-label>
              Population: {{ country.population }}
            </ion-label>
          </ion-item>
          <ion-item>
            <ion-label>
              Population rank: {{ country.population_rank }}
            </ion-label>
          </ion-item>
          <ion-item>
            <ion-label>
              Flag: <span v-html="country.flag"></span>
            </ion-label>
          </ion-item>
          <ion-item>
            <ion-label>
              Area: {{ country.area }} km²
            </ion-label>
          </ion-item>
        </ion-list>
          <ion-buttons>
            <ion-button @click="toggleFavorite" color="primary">
              <ion-icon slot="start" :icon="isFavorite ? heart : heartOutline"></ion-icon>
              {{ isFavorite ? 'Unmark Favorite' : 'Mark as Favorite' }}
            </ion-button>
          </ion-buttons>
        </ion-card-content>
      </ion-card>

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
