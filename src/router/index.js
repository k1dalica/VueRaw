import Vue from 'vue'
import Router from 'vue-router'
import user from '../services/api/user'
import Home from '../components/home/Home'
import Studio from '../components/studio/Studio'
import About from '../components/about/About'
import Login from '../components/admin/Login'
import Updates from '../components/admin/Updates'
import Admin from '../components/admin/Admin'


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
      path: '/admin/',
      component: Admin,
      children: [
        {
          path: 'updates',
          name: 'Updates',
          component: Updates,
          meta: { auth: true }
        },
        {
          path: 'login',
          name: 'Login',
          component: Login
        }
      ]
    }
  ]
})

router.beforeEach((to, from, next) => {
  console.log('saas')
  if (to.matched.some(record => record.meta.auth)) {
    if (!user.userLogged()) {
      Vue.router.push({ path: '/admin/login' })
    } else {
      next()
    }
  } else {
    next()
  }
})

export {
  router
}
