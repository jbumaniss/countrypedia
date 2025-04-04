<template>
  <AppLayout title="Countrypedia Home">
    <div class="container mx-auto p-4">
      <SearchInput @update-query="handleSearch" />

      <FavoriteCountries :favorites="favoriteCountries" />
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import SearchInput from '../../Components/SearchInput.vue';
import FavoriteCountries from '../../Components/FavoriteCountries.vue';

export default {
  name: 'Home',
  components: {
    AppLayout,
    SearchInput,
    FavoriteCountries
  },
  props: {
    favoriteCountries: {
      type: Array,
      default: () => []
    }
  },
  methods: {
    handleSearch(query) {
      console.log('Searching for:', query);
    }
  }
};
</script>
