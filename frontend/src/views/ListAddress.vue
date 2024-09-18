<script setup>
import {useStore} from "@/stores/store.js";
import {onBeforeUnmount, ref} from "vue";

const store = useStore();
store.getAddresses();

onBeforeUnmount(() => {
  store.$reset();
});

let orderBy = 'Id';
let orderAsc = true;
let deleteDialog = ref(false);
let deleteItemId = ref(null);
let deleteEmail = ref('');

function updateOrderBy(item) {
  orderAsc = orderBy === item ? !orderAsc : true;
  orderBy = item;
  store.getAddresses(orderBy, orderAsc);
}

const header = [
    'Id',
    'Name',
    'First name',
    'Email',
    'Street',
    'Zip code',
    'City'
]

</script>

<template>
  <v-row>
    <v-col cols="12">
      <v-card>
        <v-card-title>Address list</v-card-title>
        <v-card-text>
          <v-btn
              class="my-2"
              color="primary"
              :to="{name: 'createAddress'}"
          >
            Create address
          </v-btn>
          <v-table>
            <thead>
            <tr>
              <th
                  class="cursor-pointer"
                  v-for="item in header"
                  :key="item"
                  @click="updateOrderBy(item)"
              >
                <v-icon icon="mdi-sort" />
                {{ item }}
              </th>
              <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="address in store.addresses" :key="address.id">
              <td>{{ address.id }}</td>
              <td>{{ address.name }}</td>
              <td>{{ address.firstName }}</td>
              <td>{{ address.email }}</td>
              <td>{{ address.street }}</td>
              <td>{{ address.zip }}</td>
              <td>{{ address.cityName }}</td>
              <td>
                <v-btn
                    size="small"
                    color="info"
                    rounded
                    :to="{name: 'editAddress', params: {id: address.id}}"
                >
                  <v-icon icon="mdi-pencil" />
                </v-btn>
                <v-btn
                    size="small"
                    color="warning"
                    rounded
                    @click="() => {
                       deleteDialog = true;
                       deleteItemId = address.id;
                    }"
                >
                  <v-icon icon="mdi-close" />
                </v-btn>
              </td>
            </tr>
            </tbody>
          </v-table>
        </v-card-text>
      </v-card>
    </v-col>
    <v-dialog
        v-model="deleteDialog"
        width="auto"
    >
      <v-card
          max-width="400"
          prepend-icon="mdi-update"
          title="Delete address"
      >
        <v-card-text>
          <v-alert
              v-if="store.error"
              :text="store.error"
              type="error"
              class="mb-4"
              variant="tonal"
          ></v-alert>
          # {{ deleteItemId }} <br/>
          Are you sure you want to delete this address?
          Confirm with email address.
          <v-text-field
              class="mt-3"
              v-model="deleteEmail"
              label="Email"
          />
        </v-card-text>
        <template v-slot:actions>
          <v-btn
              variant="tonal"
              color="warning"
              text="Delete"
              @click="async () => {
                await store.deleteAddress(deleteItemId, deleteEmail);
                if(!store.error){
                  deleteDialog = false;
                  deleteEmail = '';
                }
              }"
          ></v-btn>
          <v-btn
              variant="tonal"
              color="info"
              text="Cancel"
              @click="deleteDialog = false"
          ></v-btn>
        </template>
      </v-card>
    </v-dialog>
  </v-row>
</template>
