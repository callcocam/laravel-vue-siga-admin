import Vue from 'vue'
import Router from 'vue-router'
import { createRouterLayout } from 'vue-router-layout'
Vue.use(Router)

const RouterLayout = createRouterLayout(layout => {
    return import('@/layouts/' + layout + '.vue')
})


import { generateRoutes } from '@/plugins/vue-router-generator'

const router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    scrollBehavior () {
        return { x: 0, y: 0 }
    },
    routes: [
        {
            name: 'admin',
            path: '/admin',
            component: RouterLayout,
            redirect:"admin/dashboard",
            children: [
                {
                    path:"dashboard",
                    component: ()=>import(`@views/admin/index`),
                    meta:{
                        auth:true
                    }
                },
                ...generateRoutes(),
                {
                    name:"admin.auth.login",
                    path:"login",
                    component: ()=>import(`@views/admin/auth/login`)
                },
                {
                    name:"admin.auth.profile",
                    path:"profile",
                    component: ()=>import(`@views/admin/auth/profile`),
                    meta:{
                        auth:true
                    }
                },
                {
                    name:"admin.auth.logout",
                    path:"logout",
                    component: ()=>import(`@views/admin/auth/logout`),
                    meta:{
                        auth:true
                    }
                },
                {
                    name:"admin.auth.register",
                    path:"register",
                    component: ()=>import(`@views/admin/auth/register`)
                },
                {
                    path:"*",
                    component:()=>import("@views/404")
                }
            ]
        }
    ]
})


router.afterEach(() => {
    // Remove initial loading

})

router.beforeEach((to, from, next) => {

    if(to.meta.auth) {
        if (!auth.isAuthenticated()) {
            if (router.currentRoute.name != 'admin.auth.logout') {
                router.push({ name: 'admin.auth.login', query: { to: to.path } })
            }
            else{
                router.push({ name: 'admin.auth.login' })
            }
        }
    }

    return next()

});

export default router;
