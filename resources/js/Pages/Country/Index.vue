<template>
  <AppLayout title="Countrypedia Home">
    <div class="container mx-auto p-4">
      <SearchInput @update-query="handleSearch" />
      <CountryList header-title="Search Results" :countries="searchResults" />
      <FavoriteCountries :favorites="favoriteCountries" />
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import SearchInput from '../../Components/SearchInput.vue';
import FavoriteCountries from '../../Components/FavoriteCountries.vue';
import CountryList from '../../Components/CountryList.vue';

export default {
  name: 'Home',
  components: {
    AppLayout,
    SearchInput,
    FavoriteCountries,
    CountryList
  },
  props: {
    countries: {
      type: Array,
      default: () => []
    },
    favoriteCountries: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      searchResults: []
    };
  },
  methods: {
    handleSearch(query) {
      console.log('Searching for:', query);
      if (query.trim() !== '') {
        // Simulate search by filtering the countries prop
        this.searchResults = this.countries.filter(country =>
            country.common_name.toLowerCase().includes(query.toLowerCase())
        );
      } else {
        this.searchResults = [];
      }
    }
  }
};
</script>
