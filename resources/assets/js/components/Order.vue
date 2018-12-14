<template>
    <div class="content">

        <p>Order!</p>

        <div v-for="order in orders"
             :key="orders.id"
        >
            <h4>
                {{order.id}} {{order.date}} {{order.number}}
            </h4>

            <table class="table">
                <thead>
                <tr>
                    <th>
                        Наименование
                    </th>
                    <th>
                        Заказ
                    </th>
                    <th>
                        Набор
                    </th>
                    <th>
                        Изменен
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="line in order.orderlines"
                    :key="line.id"
                >
                    <td>
                        {{line.productdescr}}
                    </td>
                    <td>
                        {{line.quantity}}
                    </td>
                    <td>
                        {{line.quantitymarks}}
                    </td>
                    <td>
                        {{line.updated_at}}
                    </td>
                </tr>

                </tbody>
            </table>

            <small v-for="err in order.ordererrorlines"
                :key="err.id"
            >
                {{err.id}}. {{err.markcode}}  {{err.message}} {{created_at}}  {{updated_at}}
            </small>

        </div>


        <b-pagination align="center" size="md" v-model="currentPage" :total-rows="totalCount" :per-page="pageSize" :limit=10>
        </b-pagination>

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
        watch: {
            'currentPage': 'fetchData'
        },
        methods:{
            fetchData () {
                this.itemsLoaded = false;
                this.$store
                    .dispatch('orders/loadItems', {page: this.currentPage} )
                    .then((response) => {
                        this.totalCount = response.data.total;
                        this.totalPages = response.data.last_page;
                        this.pageSize = response.data.per_page;
                        this.itemsLoaded = true;
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