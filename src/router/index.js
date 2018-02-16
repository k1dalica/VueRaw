import Vue from 'vue'
import axios from 'axios'
import Router from 'vue-router'
import Home from '../components/home/Home'
import Studio from '../components/studio/Studio'
import About from '../components/about/About'
import Login from '../components/admin/Login'
import Updates from '../components/admin/Updates'
import Admin from '../components/admin/Admin'
import AddUpdate from '../components/admin/AddUpdate'
import EditUpdate from '../components/admin/EditUpdate'
import Comments from '../components/admin/Comments'
import Newsletter from '../components/admin/Newsletter'
import APAbout from '../components/admin/About'
import APStudio from '../components/admin/Studio'

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
          path: 'comments',
          name: 'Comments',
          component: Comments,
          meta: { auth: true }
        },
        {
          path: 'about',
          name: 'APAbout',
          component: APAbout,
          meta: { auth: true }
        },
        {
          path: 'studio',
          name: 'APStudio',
          component: APStudio,
          meta: { auth: true }
        },
        {
          path: 'newsletter',
          name: 'Newsletter',
          component: Newsletter,
          meta: { auth: true }
        },
        {
          path: 'addupdate',
          name: 'AddUpdate',
          component: AddUpdate,
          meta: { auth: true }
        },
        {
          path: 'editupdate/:id',
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
          path: 'logout',
          name: 'Logout',
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
  if(to.name === 'Logout') {
    localStorage.removeItem('token')
    next({name: 'Login'})
  } else {
    if (to.matched.some(record => record.meta.auth)) {
      let token = window.localStorage.getItem('token')
      if(token !== null) {
        axios.get('http://k1d.local/api/login/'+token).then(function (res) {
          if(res.data) {
            next()
          } else {
            next({name: 'Login'})
          }
        }).catch(function (error) {
          next({name: 'Login'})
        })
      } else {
        next({name: 'Login'})
      }
    } else {
      next()
    }
  }
})

export {
  router
}
