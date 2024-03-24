<template>
    <div class="container">
        <Header />
        <main>
            <router-view></router-view>
        </main>
    </div>
</template>

<script setup>
    import Header from "./Header.vue";

</script>
