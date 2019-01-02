<template>
    <div class="container">

        <div class="row">
            <p>Order Error!</p>
        </div>

        <div v-for="errorLine in ordersErrorLine"
             :key="errorLine.id"
             class="row"
        >
            <p>
                {{errorLine.id}} Заказ № {{errorLine.order_id}} {{errorLine.message}}
            </p>

        </div>


        <b-pagination align="center" size="md" v-model="currentPage" :total-rows="totalCount" :per-page="pageSize" :limit=10>
        </b-pagination>

    </div>

</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: 'OrderError',
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
                ordersErrorLine: 'orders/itemsErrorLine'
            })
        },
        watch: {
            'currentPage': 'fetchData'
        },
        methods:{
            fetchData () {
                //this.itemsLoaded = false;
                this.$store
                    .dispatch('orders/loadItemsErrorLine', {page: this.currentPage} )
                    .then((response) => {
                        this.totalCount = response.data.total;
                        this.totalPages = response.data.last_page;
                        this.pageSize = response.data.per_page;
                        //this.itemsLoaded = true;
                        this.error = null;
                    }).catch(error => {
                        this.itemsLoaded = true;
                        if (error === undefined) {
                            this.error = 'error!!!';
                        } else {
                            this.error = error.data.error;
                        }
                    });
            }
        }
    }

</script>