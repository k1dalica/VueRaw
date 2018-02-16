<template>
  <div>
    <AdminNav />
    
  </div>
</template>

<script>
import AdminNav from '../common/AdminNav'
import axios from 'axios'

export default {
  name: 'Newsletter',
  data () {
    return {
      token: '',
      text: []
    }
  },
  created () {
    this.token = window.localStorage.getItem('token')
    this.getText()
  },
  methods: {
    getText () {
    //   let self = this
    //   axios.get('http://k1d.local/api/comment', { responseType: 'json' }).then(function (res) {
    //     self.comments = res.data.data
    //   }).catch(function (error) {
    //     console.log(error)
    //   })
    }
  },
  components: {
    AdminNav
  }
}
</script>

<style scoped>
</style>