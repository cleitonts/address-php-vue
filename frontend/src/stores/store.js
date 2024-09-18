import {ref, computed} from 'vue'
import {defineStore} from 'pinia'
import axios from 'axios'
import router from "@/router/index.js";

export const useStore = defineStore('store', {
    state: () => {
        return {
            addresses: [],
            cities: [],
            address: {},
            error: ''
        }
    },
    actions: {
        async getCity() {
            if (this.cities.length > 0) {
                return
            }

            const result = await axios.get(import.meta.env.VITE_API_URL + '/city')
            this.cities = result.data
        },

        async getAddresses(orderBy = 'Id', order = true) {
            const result = await axios.get(import.meta.env.VITE_API_URL + '/address', {
                params: {
                    orderBy: orderBy,
                    order: !!order ? 'asc' : 'desc'
                }
            })
            this.addresses = result.data
        },

        async getAddress(id) {
            const result = await axios.get(import.meta.env.VITE_API_URL + '/address/' + id)
            this.address = result.data
        },

        async saveAddress() {
            if (this.address.id) {
                const response = await axios.put(import.meta.env.VITE_API_URL + '/address/' + this.address.id, this.address)
                if (response.data.error) {
                    this.error = response.data.error
                    return
                }
                await router.push({name: 'listAddress'})
            } else {
                const response = await axios.post(import.meta.env.VITE_API_URL + '/address', this.address)
                if (response.data.error) {
                    this.error = response.data.error
                    return
                }
                await router.push({name: 'editAddress', params: {id: response.data}})
            }
        },

        async deleteAddress(id, email) {
            try {
                await axios.delete(import.meta.env.VITE_API_URL + '/address/' + id, {
                    data: {
                        email
                    }
                })
                this.error = '';
                await this.getAddresses()
            } catch (e) {
                this.error = 'Invalid email'
            }
            await this.getAddresses()
        }
    }
});