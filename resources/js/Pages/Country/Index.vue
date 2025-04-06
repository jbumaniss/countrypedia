<template>
  <AppLayout title="Countrypedia Home">
    <ion-card>
      <ion-card-content>
      <SearchInput @update-query="handleSearch" />
        <CountryList
            v-if="searchResults.length > 0"
            header-title="Search Results"
            :countries="searchResults"
        />
      </ion-card-content>
    </ion-card>

      <CountryList
          v-if="favoriteCountriesToShow.length > 0"
          header-title="Favorite Countries"
          :countries="favoriteCountriesToShow"
      />
  </AppLayout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import SearchInput from '../../Components/SearchInput.vue';
import { getFavorites } from '@/utils/favorites.js';
import { router } from '@inertiajs/vue3'
import CountryList from "@/Pages/Country/Partials/CountryList.vue";

export default {
  name: 'Home',
  components: {
    AppLayout,
    SearchInput,
    CountryList
  },
  props: {
    favoriteCountries: {
      type: Array,
      default: () => []
    },
    countries: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      searchResults: [],
      localFavorites: []
    };
  },
  computed: {
    favoriteCountriesToShow() {
      return (this.favoriteCountries && this.favoriteCountries.length > 0)
          ? this.favoriteCountries
          : this.localFavorites;
    }
  },
  methods: {
    async handleSearch(query) {
      const trimmed = query.trim();
      if (!trimmed) {
        this.searchResults = [];
        return;
      }

      router.get('/', {
        search: trimmed
      }, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (response) => {
          this.searchResults = response.props.countries;
        },
        onError: (error) => {
          console.error('Search error:', error);
        }
      });
    },
    loadFavorites() {
      this.localFavorites = getFavorites();
    }
  },
  mounted() {
    this.loadFavorites();
  }
};
</script>