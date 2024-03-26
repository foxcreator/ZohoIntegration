<template>
    <form @submit.prevent="submitForm" class="d-flex flex-column align-items-center gap-3">
        <div class="form-group w-50">
            <div class="input-group">
                <span class="input-group-text">Account name</span>
                <input type="text" v-model="accountName" class="form-control">
            </div>
            <p class="text-danger m-0" v-if="errors.accountName" v-for="error in errors.accountName">{{ error }}</p>
        </div>
        <div class="form-group w-50">
            <div class="input-group">
                <span class="input-group-text">Account website</span>
                <input type="text" v-model="accountWebsite" class="form-control">
            </div>
            <p class="text-danger m-0" v-if="errors.accountWebsite" v-for="error in errors.accountWebsite">{{ error }}</p>
        </div>
        <div class="form-group w-50">
            <div class="input-group">
                <span class="input-group-text">Account phone</span>
                <input type="text" v-model="accountPhone" class="form-control">
            </div>
            <p class="text-danger m-0" v-if="errors.accountPhone" v-for="error in errors.accountPhone">{{ error }}</p>
        </div>
        <input type="hidden" :value="store.ownerId">

        <button type="submit" class="btn btn-sm btn-success">Create</button>
    </form>
</template>
<script setup>
import { defaultStore } from "../../store.js";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import { useNotify } from "../../composables/useNotify.js";
import { useApi } from "../../composables/useApi.js";

const store = defaultStore();
const { successNotify, errorNotify } = useNotify();
const { getOwner } = useApi();
const router = useRouter();
const accountName = ref('');
const accountWebsite = ref('');
const accountPhone = ref('');
const errors = ref({});

const submitForm = () => {
    axios.post('/api/accounts/create', {
            ownerId: store.ownerId,
            accountName: accountName.value,
            accountWebsite: accountWebsite.value,
            accountPhone: accountPhone.value,
        },
        {
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(res => {
            console.log(res)
            if (res.data === 201) {
                router.push('home');
                setTimeout(() => {
                    successNotify('The Account has been successfully created!');
                }, 200);
            }
        })
        .catch(error => {
            console.log(error);
            errors.value = error.response.data.errors;
            errorNotify('Something went wrong. Try again.');
        })
}

onMounted(() => {
    getOwner();
})
</script>
