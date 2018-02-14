<template>
  <div class="admin-login">
    <h1>Admin login</h1>
    <div class='notify error mb-20' v-if="error"><div class='icon'></div><div class='text'>{{ msg }}</div><div class='close'><i @click="error = !error"></i></div></div>
    <input type="text" placeholder="Username" class="input nbb" v-model="username">
    <input type="password" @keyup.enter="login" placeholder="Password" class="input" v-model="password">
    <button @click="login">Login</button>
  </div>
</template>

<script>
import axios from 'axios'
import user from '../../services/api/user'

export default {
  name: 'Login',
  data () {
    return {
      error: false,
      msg: '',
      username: '',
      password: ''
    }
  },
  created () {
    if (user.userLogged()) {
      this.router.push({ name: 'Updates'})
    }
  },
  methods: {
    login () {
      let self = this
      this.error = false
      this.msg = ''
      if(this.username == '') {
        this.error = true
        this.msg = 'Field username is empty !'
      } else if(this.password == '') {
        this.error = true
        this.msg = 'Field password is empty !'
      } else {
        let params = new URLSearchParams()
        params.append('username', this.username)
        params.append('password', this.password)
        self.password = ''
        axios.post('http://k1d.local/api/login', params).then(function (res) {
          if(res.data.status) {
            localStorage.setItem("token", res.data.token);
          } else {
            self.error = true
            self.msg = res.data.msg
          }
        }).catch(function (error) {
          console.log(error)
        })
      }
    }
  },
  components: {
  }
}
</script>

<style scoped>
.admin-login { width: 350px; margin: 0 auto; text-align: center; margin-top: 100px; }
.admin-login h1 { margin-bottom: 40px; }
.admin-login .input { text-align: center; border: 1px solid #212121;  display: block; width: 100%; height: 50px; outline: none; background-color: transparent; color: #212121; font-size: 17px; padding: 0 15px; box-sizing: border-box; }
.admin-login .nbb { border-bottom: none; }
.admin-login button { margin-top: 20px; }
</style>
