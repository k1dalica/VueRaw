import Router from 'vue-router'
import user from '../services/api/user'
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
      name: 'Admin',
      component: Login,
      children: [
        {
          path: '/login',
          name: 'Login'
          component: Login
        },
        {
          path: '/updates',
          component: Login,
          meta: { auth: true },
        }
      ]
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.auth)) {
    if (!user.getToken()) {
      next({
        name: 'Login',
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }
})

export {
  router
}
