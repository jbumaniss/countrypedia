<template>
  <ion-list>
    <ion-list-header
        lines="inset"
        class="font-bold"
    >
      <ion-label>{{ headerTitle }}</ion-label>
    </ion-list-header>
    <ion-item
        v-for="country in countries"
        :key="country.id"
        :href="route('countries.show', country.id)">
      <ion-label>{{ country.common_name }}</ion-label>
    </ion-item>
  </ion-list>
</template>

<script>
export default {
  name: 'CountryList',
  props: {
    headerTitle: {
      type: String,
      default: 'Countries'
    },
    countries: {
      type: Array,
      default: () => []
    }
  }
};
</script>
