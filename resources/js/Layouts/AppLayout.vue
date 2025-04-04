<template>
<ion-page class="flex flex-col h-screen">
<ion-header>
  <ion-toolbar class="bg-blue-500">
    <ion-breadcrumbs>
      <ion-breadcrumb href="/">Countries</ion-breadcrumb>
    </ion-breadcrumbs>
  </ion-toolbar>
</ion-header>
<ion-content class="ion-padding">
  <slot></slot>
</ion-content>
</ion-page>
</template>

<script>
export default {
  name: 'AppLayout',
  props: {
    title: {
      type: String,
      default: 'Countrypedia'
    }
  }
};
</script>

