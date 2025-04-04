<template>
  <ion-item>
    <ion-input
        v-model="query"
        @keyup.enter="onSearch"
        placeholder="Type and press Enter"
        label="Search for a country"
    ></ion-input>
  </ion-item>
</template>

<script>
export default {
  name: 'SearchInput',
  data() {
    return {
      query: ''
    };
  },
  methods: {
    onSearch() {
      this.$emit('update-query', this.query);
    }
  }
};
</script>
