<template>
  <AppLayout title="Countrypedia Home">
    <div class="container mx-auto p-4">
      <SearchInput @update-query="handleSearch" />

      <CountryList
          v-if="searchResults.length > 0"
          header-title="Search Results"
          :countries="searchResults"
      />

      <CountryList
          v-if="favoriteCountriesToShow.length > 0"
          header-title="Favorite Countries"
          :countries="favoriteCountriesToShow"
      />
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import SearchInput from '../../Components/SearchInput.vue';
import CountryList from '../../Components/CountryList.vue';
import { getFavorites } from '../../utils/favorites';

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
    handleSearch(query) {
      console.log('Searching for:', query);
      if (query.trim() !== '') {
        this.searchResults = this.countries.filter(country =>
            country.common_name.toLowerCase().includes(query.toLowerCase())
        );
      } else {
        this.searchResults = [];
      }
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
