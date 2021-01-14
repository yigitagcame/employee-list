import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from'./components/Home';
import Create from'./components/Create';
import Update from'./components/Update';

Vue.use(VueRouter);

export default new VueRouter({

    mode: 'history',
    routes: [
        {path: '/', component: Home},
        {path: '/new', component: Create},
        {path: '/edit/:id', component: Update},
        { path: '*', redirect: '/'}
    ]
})
