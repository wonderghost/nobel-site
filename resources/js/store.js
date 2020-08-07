import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    sectionList : []
  },
  mutations: {
    setSection (state , list) {
        state.sectionList = list
    }
  }
})

export default store