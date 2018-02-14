<template>
    <div id="top-items">
        <div class="visits">
            <img src="./../../assets/images/visits.png">
            <span>{{visits}}</span>
        </div><div class="subscribe" @click="subscribe">
            <img src="./../../assets/images/subscribe.png">
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'TopItems',
  data () {
    return {
      visits: 0
    }
  },
  created() {
    this.visitsAdd();
  },
  methods: {
    subscribe() {
      let email = prompt("Enter your email address to subscribe to our newsletter.");
      if(this.validateEmail(email)) {
        let params = new URLSearchParams()
        params.append('email',email)
        axios.post('http://k1d.local/api/subscribe', params).then(function (res) {
          alert(res.data.msg);
        }).catch(function (error) {
          console.log(error)
        })
      } else {
        this.subscribe();
      }
    },

    visitsAdd() {
      let self = this
      axios.post('http://k1d.local/api/visits', { responseType: 'json' }).then(function (res) {
        self.visits = res.data.data
      }).catch(function (error) {
        console.log(error)
      })
    },

    getVisits() {
      let self = this
      axios.get('http://k1d.local/api/visits', { responseType: 'json' }).then(function (res) {
        self.visits = res.data.data
      }).catch(function (error) {
        console.log(error)
      })
    },

    validateEmail(email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return re.test(email.toLowerCase())
    }
    // getVisits() {
      // axios.get('/user', {
      //   params: {
      //     ID: 12345
      //   }
      // }).then(function (res) {
      //   console.log(res);
      // }).catch(function (error) {
      //   console.log(error);
      // });
    // }
  }
}
</script>

<style scoped>
  #top-items { width: 100%; max-width: 1400px; min-width: 1024px; position: absolute; top: 50px; left: 0; right: 0; margin: 0 auto; height: 0; }
  #top-items .subscribe { float: right; text-align: center; cursor: pointer; vertical-align: middle; margin-top: 8px; }
  #top-items .visits { float: right; text-align: center; margin-left: 30px; }
  #top-items .visits span { display: block; font-size: 22px; font-weight: bold; }
</style>
