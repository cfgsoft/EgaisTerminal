<template>
    <div>
        <p>Order Edit {{orderId}}</p>
        {{order}}
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: 'OrderEdit',
        created () {
            this.$store.dispatch('orders/loadOrder', this.$route.params.id)
                .then(response => {
                    //this.error = null;
                    //this.email = "";
                    //this.password = "";

                    //if (this.$route.query.redirect) {
                    //  this.$router.push(this.$route.query.redirect);
                    //}
                })
                // eslint-disable-next-line
                .catch(error => {
                    //console.log(error);
                    //if (error === undefined) {
                    //  this.error = '╨¥╨╡╤é ╤ü╨▓╤Å╨╖╨╕ c API ╤ü╨╡╤Ç╨▓╨╡╤Ç╨╛╨╝';
                    //} else {
                    //  this.error = error.data.error;
                    //}
                });
        },

        computed: {
            ...mapGetters({
                order: 'orders/order'
            }),
            orderId() {
                return this.$route.params.id;
            }
        }
    }
</script>