<template>
  <ion-list>
    <ion-list-header>Favorite Countries</ion-list-header>
    <ion-item
        v-for="country in favorites"
        :key="country.id"
        :href="`/country/${country.id}`">
      <ion-label>{{ country.common_name }}</ion-label>
    </ion-item>
  </ion-list>
</template>

<script>
export default {
  name: 'FavoriteCountries',
  props: {
    favorites: {
      type: Array,
      default: () => []
    }
  }
};
</script>
