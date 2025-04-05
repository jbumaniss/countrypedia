<template>
  <ion-list>
    <ion-list-header>{{ headerTitle }}</ion-list-header>
    <ion-item
        v-for="language in languages"
        :key="language.id"
        :href="route('languages.show', language.id)">
      <ion-label>{{ language.name }}</ion-label>
    </ion-item>
  </ion-list>
</template>

<script>
export default {
  name: 'LanguageList',
  props: {
    headerTitle: {
      type: String,
      default: 'Languages'
    },
    languages: {
      type: Array,
      default: () => []
    }
  }
};
</script>
