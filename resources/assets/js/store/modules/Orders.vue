<script>
import Vue from 'vue';

export default {
  namespaced: true,
  state: {
    items: [],
    order: {},
    itemsErrorLine: []
  },
  getters: {
    items(state) {
      return state.items;
    },
    order(state) {
      return state.order;
    },
    itemsErrorLine(state) {
      return state.itemsErrorLine;
    },
  },
  mutations: {
    setItems(state, data) {
      state.items = data
    },
    setOrder(state, data) {
      state.order = data
    },
    setItemsErrorLine(state, data) {
      state.itemsErrorLine = data
    },
  },
  actions: {
    loadItems(store, params) {
        return new Promise((resolve, reject) => {
            window.axios
                .get('/api/v1/orders', {params: {page: params.page}, withCredentials: true} )
                .then((response) => {
                    store.commit('setItems', response.data.data);
                    resolve(response);
                }).catch(error => {
                    reject(error.response);
                });
        });
    },
    loadOrder(store, orderId) {
      return new Promise((resolve, reject) => {
          window.axios
              .get('/api/v1/orders/' + orderId)
              .then((response) => {
                  store.commit('setOrder', response.data);
                  resolve(response);
              }).catch(error => {
                reject(error.response);
              });
      });
    },
    loadItemsErrorLine(store, params) {
      return new Promise((resolve, reject) => {
        window.axios
            .get('/api/v1/orders/indexerrorline', {params: {page: params.page}} )
            .then((response) => {
              store.commit('setItemsErrorLine', response.data.data);
              resolve(response);
            }).catch(error => {
              reject(error.response);
            });
      });
    }
  }
}

</script>