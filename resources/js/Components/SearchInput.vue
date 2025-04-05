<template>
  <ion-searchbar
  v-model="query"
  @ionClear="() => { query = ''; onSearch(); }"
  ></ion-searchbar>
</template>

<script>
import { searchOutline } from 'ionicons/icons';

export default {
  name: 'SearchInput',
  data() {
    return {
      searchOutline,
      query: ''
    };
  },
  watch: {
    query() {
      this.onSearch();
    }
  },
  methods: {
    onSearch() {
      this.$emit('update-query', this.query);
    }
  }
};
</script>
