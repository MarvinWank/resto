<template>
    <div class="homescreen-header">
        <p class="homescreen-headline">resto</p>
    </div>
</template>

<script>
export default {
    name: "RestoHeader"
}
</script>

<style scoped>
.homescreen-header {
    width: 100%;
    height: 5rem;
    text-align: center;
    display: flex;
    align-content: center;
    justify-content: center;
    align-items: center;
    border-bottom: 1px solid #d9d6d6;
}

.homescreen-headline {
    margin: 0;
    font-size: 3rem;
    color: #3D9128;
}
</style>
