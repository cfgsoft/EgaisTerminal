<template>
    <div class="content">

    <p>Order!</p>

    <div v-for="order in orders"
         :key="orders.id"
    >
        <p>
            {{order.id}} {{order.date}} {{order.number}}
        </p>
    </div>

    </div>

</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: 'Order',
        created(){
            this.fetchData();
        },
        data(){
            return {
                totalCount: 0,
                totalPages: 0,
                currentPage: 1,
                pageSize: 1,
                itemsLoaded: false,
                error: null
            }
        },
        computed: {
            ...mapGetters({
                orders: 'orders/items'
            })
        },
        methods:{
            fetchData () {
                this.itemsLoaded = false;
                this.$store
                    .dispatch('orders/loadItems')
                    .then((response) => {
                        console.log(111111);
                        //this.totalCount = response.data.totalCount;
                        //this.totalPages = response.data.totalPages;
                        //this.pageSize = response.data.pageSize;
                        //this.itemsLoaded = true;
                        //this.error = null;
                    }).catch(error => {
                    this.itemsLoaded = true;
                    if (error === undefined) {
                        this.error = 'eroor!!!';
                    } else {
                        this.error = error.data.error;
                    }
                });

            }
        }
    }

</script>