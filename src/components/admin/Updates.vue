<template>
  <div>
    <AdminNav />
    
    <div class="admin-container">
      <div>
        <router-link :to="{ name: 'AddUpdate' }"><button class="floatr">Add new update</button></router-link>
        <div class="clear"></div>
      </div>
      <ul class="list">
        <li v-for="(update, index) in updates" :key="index">
          <span>{{update.number}}</span>
          <div class='buttons'>
            <router-link :to="{ name: 'EditUpdate', params: {id: update.id}}"><button>Edit</button></router-link>
            <button @click="deleteUpdate(update)">X</button>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import AdminNav from '../common/AdminNav'
import axios from 'axios'

export default {
  name: 'Updates',
  data () {
    return {
      token: '',
      updates: []
    }
  },
  created () {
    this.token = window.localStorage.getItem('token')
    this.getUpdates()
  },
  methods: {
    deleteUpdate (update) {
      if(confirm('Are u sure you want to delete this update:\r\n' + update.number)) {
        let self = this
        let data = new FormData();
        data.append("token", this.token)
        let params = new URLSearchParams()
        params.append('token', this.token)
        axios.delete('http://k1d.local/api/update/'+update.id, {
          params: {
            token: self.token
          }
        }).then(function (res) {
          let nr = self.updates.filter(fl => {
            return fl.id !== update.id
          })
          self.updates = nr
        }).catch(function (error) {
          console.log(error)
        })
      }
    },
    getUpdates () {
      var self = this
      self.busy = true
      axios.get('http://k1d.local/api/updates/all', { responseType: 'json' }).then(function (res) {
        self.updates = res.data.data
      }).catch(function (error) {
        console.log(error)
      })
    }
  },
  components: {
    AdminNav
  }
}
</script>

<style scoped>
</style>