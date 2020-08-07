import Vue from 'vue'
import VueRouter from 'vue-router'
// import AfrocashOperation from './pdcComponents/AfrocashOperation.vue'
// import PdcTransaction from './pdcComponents/PdcTransaction.vue'
// import InventairePdraf from './pdcComponents/InventairePdraf.vue'
import homeComponent from './components/homeComponent.vue'

Vue.use(VueRouter);

const router = new VueRouter({
    mode : 'hash',
    routes:[
        {
            path:"/",
            component : homeComponent
        },
    ]



})
export default router