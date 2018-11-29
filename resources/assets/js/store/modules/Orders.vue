<script>
import Vue from 'vue';

export default {
  namespaced: true,
  state: {
    items: {},
    order: {}
  },
  getters: {
    items(state) {
      return state.items;
    },
    order(state) {
      return state.order;
    }
  },
  mutations: {
    setItems(state, data) {
      state.items = data
    },
    setOrder(state, data) {
      state.order = data
    }
  },
  actions: {
    loadItems(store, params) {
        return new Promise((resolve, reject) => {
            window.axios
                .get('/api/v1/orders')
                .then((response) => {
                    store.commit('setItems', response.data);
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
    }
  }
}

</script>