<template>
<form @submit.prevent="submitForm" class="d-flex flex-column align-items-center gap-3">
    <div class="form-group w-50">
        <div class="input-group">
            <span class="input-group-text" id="deal_name">Deal name</span>
            <input type="text" v-model="dealName" class="form-control" aria-label="deal_name">
        </div>
        <p class="text-danger m-0" v-if="errors.dealName" v-for="error in errors.dealName">{{ error }}</p>
    </div>
    <div class="form-group w-50">
        <div class="input-group">
            <span class="input-group-text" id="inputGroup-sizing-default">Closing date</span>
            <input type="date" v-model="closingDate" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <p class="text-danger m-0" v-if="errors.closingDate" v-for="error in errors.closingDate">{{ error }}</p>
    </div>
    <div class="form-group w-50">
        <div class="input-group">
            <span class="input-group-text" id="inputGroup-sizing-default">Stage</span>
            <select v-model="stage" class="form-select" aria-label="Default select example">
                <option v-for="stage in store.stages" :value="stage.display_value">{{ stage.display_value }}</option>
            </select>
        </div>
        <p class="text-danger m-0" v-if="errors.stage" v-for="error in errors.stage">{{ error }}</p>
    </div>
    <div class="form-group w-50">
        <div class="input-group">
            <span class="input-group-text" id="inputGroup-sizing-default">Account name</span>
            <select v-model="accountId" class="form-select" aria-label="Default select example">
                <option v-for="account in store.accounts" :value="account.id">{{ account.Account_Name }}</option>
            </select>
        </div>
        <p class="text-danger m-0" v-if="errors.accountId" v-for="error in errors.accountId">{{ error }}</p>
    </div>
    <input type="hidden" :value="store.ownerId">

    <button type="submit" class="btn btn-sm btn-success">Create</button>
</form>
</template>
<script setup>

import { onMounted, ref } from "vue";
import { defaultStore } from "../../store.js";
import { useRouter } from "vue-router";
import { useApi } from "../../composables/useApi.js";
import { useNotify } from "../../composables/useNotify.js";

const { getStages, getAccounts, getOwner } = useApi();
const { successNotify, errorNotify } = useNotify();
const ownerId = ref('');
const dealName = ref('');
const closingDate = ref('');
const stage = ref('');
const accountId = ref('');
const store = defaultStore();
const router = useRouter();
const errors = ref({});

const submitForm = () => {
    axios.post('/api/deals/create', {
        ownerId: store.ownerId,
        dealName: dealName.value,
        closingDate: closingDate.value,
        stage: stage.value,
        accountId: accountId.value
    },
        {
            headers: {
                'Content-Type': 'application/json'
            }
        })
    .then(res => {
        if (res.data === 201) {
            router.push('home');
            setTimeout(() => {
                successNotify('The Deal has been successfully created!');
            }, 200);
        }
    })
    .catch(error => {
        errors.value = error.response.data.errors;
        errorNotify('Something went wrong. Try again.');
    })
};

onMounted(() => {
    getStages();
    getAccounts();
    getOwner();
});

</script>
