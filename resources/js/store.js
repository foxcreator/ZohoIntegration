import { defineStore } from "pinia";
import {ref} from "vue";

export const defaultStore = defineStore('store', () => {
    const stages = ref({});
    const accounts = ref({});
    const ownerId = ref('');
})
