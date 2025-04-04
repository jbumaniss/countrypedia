<template>
  <ion-item>
    <ion-input label="Search for a country" v-model="query" @ionChange="onChange"></ion-input>
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
    onChange() {
      this.$emit('update-query', this.query);
    }
  }
};
</script>
