<template>
<form @submit.prevent="submitForm" class="d-flex flex-column align-items-center gap-3">
    <div class="input-group w-50">
        <span class="input-group-text" id="deal_name">Deal name</span>
        <input type="text" v-model="dealName" class="form-control" aria-label="deal_name">
    </div>
    <div class="input-group w-50">
        <span class="input-group-text" id="inputGroup-sizing-default">Closing date</span>
        <input type="date" v-model="closingDate" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
    </div>
    <div class="input-group w-50">
        <span class="input-group-text" id="inputGroup-sizing-default">Stage</span>
        <select v-model="stage" class="form-select" aria-label="Default select example">
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
    </div>
    <div class="input-group w-50">
        <span class="input-group-text" id="inputGroup-sizing-default">Account name</span>
        <select v-model="accountName" class="form-select" aria-label="Default select example">
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
    </div>

    <button type="submit" class="btn btn-sm btn-success">Create</button>
</form>
</template>
<script setup>

import {ref} from "vue";

const dealName = ref('');
const closingDate = ref('');
const stage = ref('');
const accountName = ref('');

const submitForm = () => {
    axios.post('/api/deals/create', {
        dealName: dealName.value,
        closingDate: closingDate.value,
        stage: stage.value,
        accountName: accountName.value
    })
    .then(res => {
        console.log(res);
    })
    .catch(error => {
        console.log(error);
    })
};
</script>


<style scoped>



</style>
