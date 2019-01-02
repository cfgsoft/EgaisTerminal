<template>
    <div>
        <h1>Terminal admin</h1>

        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'hello' }">Hello World</router-link> |
            <router-link :to="{ name: 'order' }">Order</router-link> |
            <router-link :to="{ name: 'orderError' }">Order error</router-link>
        </p>

        <router-view></router-view>

    </div>
</template>

<script>
    export default {}
</script>