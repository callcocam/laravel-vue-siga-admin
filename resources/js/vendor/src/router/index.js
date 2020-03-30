import Vue from 'vue'
import Router from 'vue-router'
import routes from 'vue-auto-routing'
import { createRouterLayout } from 'vue-router-layout'

Vue.use(Router)
console.log(routes)
const RouterLayout = createRouterLayout(layout => {
  return import('@/layouts/' + layout + '.vue')
})

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior () {
      return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      component: RouterLayout,
      children: routes
    }
  ]
})


export default router;