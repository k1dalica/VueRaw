import Router from 'vue-router'
import Home from '../components/home/Home'
import Studio from '../components/studio/Studio'
import About from '../components/about/About'
import Login from '../components/admin/Login'


let router = new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/studio',
      name: 'Studio',
      component: Studio
    },
    {
      path: '/about',
      name: 'About',
      component: About
    },
    {
      path: '/admin',
      component: Login,
      children: [
        {
          path: '/login',
          component: Login
        },
        {
          path: '/updates',
          component: Login
        }
      ]
    }
  ]
})

export {
  router
}
