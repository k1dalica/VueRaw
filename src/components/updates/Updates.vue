<template>
  <section class="updates">
    <Update v-for="(update, index) in updates" :key="index" :update="update" />
    <div v-infinite-scroll="loadMore" infinite-scroll-disabled="busy" infinite-scroll-distance="300">
    </div>
  </section>
</template>

<script>
import axios from 'axios';
import Update from '../updates/Update'

export default {
  name: 'Updates',
  data () {
    return {
      updates: [],
      busy: true,
      page: 1,
      allloaded: false
    }
  },
  created() {
    this.getUpdates()
  },
  methods: {
    getUpdates () {
      var self = this
      self.busy = true
      axios.get('http://k1d.local/api/updates/' + this.page, { responseType: 'json' }).then(function (res) {
        let u = res.data.data
        for(let i = 0; i < u.length; i++) {
          self.updates.push(u[i])
        }
        if(res.data.lastpage === false) {
          self.busy = false
        } else {
          self.allloaded = true
        }
      }).catch(function (error) {
        console.log(error)
      });
    },
    loadMore () {
      if(!this.allloaded) {
        this.page++
        this.getUpdates ()
      }
    }
  },
  components: {
    Update
  }
}
</script>

<style scoped>
  .updates { border-top: 20px solid #212121; padding-top: 1px; padding-bottom: 50px; }
</style>
