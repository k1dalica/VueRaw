import Vue from 'vue'
import Router from 'vue-router'
import user from '../services/api/user'
import Home from '../components/home/Home'
import Studio from '../components/studio/Studio'
import About from '../components/about/About'
import Login from '../components/admin/Login'
import Updates from '../components/admin/Updates'
import Admin from '../components/admin/Admin'
import AddUpdate from '../components/admin/AddUpdate'
import EditUpdate from '../components/admin/EditUpdate'

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
          path: '/',
          name: 'Updates',
          component: Updates,
          meta: { auth: true }
        },
        {
          path: 'addupdate',
          name: 'AddUpdate',
          component: AddUpdate,
          meta: { auth: true }
        },
        {
          path: 'editupdate',
          name: 'EditUpdate',
          component: EditUpdate,
          meta: { auth: true }
        },
        {
          path: 'login',
          name: 'Login',
          component: Login
        },
        {
          path: '*',
          component: Login
        }
      ]
    },
    {
      path: '*',
      component: Home
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.auth)) {
    if (!user.userLogged()) {
      next({name: 'Login'})
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
