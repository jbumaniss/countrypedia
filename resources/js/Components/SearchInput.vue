<template>
  <ion-item>
    <ion-input
        label-placement="floating"
        v-model="query"
        @keyup.enter="onSearch"
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
