<script setup>
import {useStore} from "@/stores/store.js";
import {useRoute} from "vue-router";
import { onBeforeUnmount } from "vue";

const store = useStore();
const route = useRoute();
let title = 'Create address';
let btn = 'Create';

store.getCity();
if (route.name === 'editAddress') {
  await store.getAddress(route.params.id);
  title = 'Edit address #' + store.address.id;
  btn = 'Update';
}

onBeforeUnmount(() => {
  store.$reset();
});

</script>

<template>
  <v-row>
    <v-col cols="12">
      <v-alert
          v-if="store.error"
          :text="store.error"
          type="error"
          class="mb-4"
          variant="tonal"
      ></v-alert>
      <v-card>
        <v-card-title>{{ title }}</v-card-title>
        <v-card-text>
          <v-btn
              class="my-2"
              color="primary"
              :to="{name: 'listAddress'}"
          >
            Address list
          </v-btn>

          <v-form>
            <v-text-field label="Name" v-model="store.address.name"/>
            <v-text-field label="First name" v-model="store.address.firstName"/>
            <v-text-field label="Email" v-model="store.address.email"/>
            <v-text-field label="Street" v-model="store.address.street"/>
            <v-text-field label="Zip code" v-model="store.address.zip"/>
            <v-select
                label="City"
                item-value="id"
                item-title="name"
                v-model="store.address.city_id"
                :items="store.cities"
            />
            <v-btn
                @click="store.saveAddress"
                color="success"
            >{{ btn }}</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>