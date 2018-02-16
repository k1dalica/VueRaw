<template>
  <div>
    <AdminNav />
    
    <div class="admin-container">
      <h2>Comments waiting approval</h2>
      <section class="comments">
          <div class="posted-comments">
            <div class='comment' v-for="comment in unseen">
              <div class='info'>
                <div class='buttons'>
                  <button class='small-btn' @click="setStatus(comment, '1')"><i class='fa fa-check' aria-hidden='true'></i></button>
                  <button class='small-btn' @click="setStatus(comment, '2')"><i class='fa fa-times' aria-hidden='true'></i></button>
                </div>
                <span class='name'>{{ comment.name }}</span>
                <span class='date'>{{ comment.date }}</span>
              </div>
              <div class='text'>{{ comment.text }}</div>
            </div>
            <div v-if="unseen.length === 0" class='notify mb-20'><div class='icon'></div><div class='text'>There are no comments waiting for approval !</div></div>
          </div>
      </section>

      <h2>Approved comments</h2>
      <section class="comments">
          <div class="posted-comments">
            <div class='comment' v-for="comment in approved">
              <div class='info'>
                <div class='buttons'>
                  <button class='small-btn' @click="setStatus(comment, '2')"><i class='fa fa-times' aria-hidden='true'></i></button>
                </div>
                <span class='name'>{{ comment.name }} <i class='fa fa-heart white' aria-hidden='true'></i> {{ comment.likes }}</span>
                <span class='date'>{{ comment.date }}</span>
              </div>
              <div class='text'>{{ comment.text }}</div>
            </div>
            <div v-if="approved.length === 0" class='notify mb-20'><div class='icon'></div><div class='text'>There are no approved comments !</div></div>
          </div>
      </section>

      <h2>Not approved comments</h2>
      <section class="comments">
          <div class="posted-comments">
            <div class='comment' v-for="comment in notapproved">
              <div class='info'>
                <div class='buttons'>
                  <button class='small-btn' @click="setStatus(comment, '1')"><i class='fa fa-check' aria-hidden='true'></i></button>
                </div>
                <span class='name'>{{ comment.name }}</span>
                <span class='date'>{{ comment.date }}</span>
              </div>
              <div class='text'>{{ comment.text }}</div>
            </div>
            <div v-if="notapproved.length === 0" class='notify mb-20'><div class='icon'></div><div class='text'>There are no comments that are not approved !</div></div>
          </div>
      </section>
    </div>
  </div>
</template>

<script>
import AdminNav from '../common/AdminNav'
import axios from 'axios'

export default {
  name: 'Comments',
  data () {
    return {
      token: '',
      comments: []
    }
  },
  created () {
    this.token = window.localStorage.getItem('token')
    this.getComments()
  },
  computed: {
    approved() {
      return this.comments.filter(c => {
        return c.approved == '1'
      })
    },
    notapproved() {
      return this.comments.filter(c => {
        return c.approved == '2'
      })
    },
    unseen() {
      return this.comments.filter(c => {
        return c.approved == '0'
      })
    }
  },
  methods: {
    setStatus (comment, status) {
      let self = this
      comment.approved = status
      
      let params = new URLSearchParams()
      params.append('token', this.token)
      params.append('state', status)
      axios.post('http://k1d.local/api/comment/'+comment.id, params)
    },
    // deleteUpdate (update) {
    //   if(confirm('Are u sure you want to delete this update:\r\n' + update.number)) {
    //     let self = this
    //     let data = new FormData();
    //     data.append("token", this.token)
    //     let params = new URLSearchParams()
    //     params.append('token', this.token)
    //     axios.delete('http://k1d.local/api/update/'+update.id, {
    //       params: {
    //         token: self.token
    //       }
    //     }).then(function (res) {
    //       let nr = self.updates.filter(fl => {
    //         return fl.id !== update.id
    //       })
    //       self.updates = nr
    //     }).catch(function (error) {
    //       console.log(error)
    //     })
    //   }
    // },
    getComments () {
      let self = this
      axios.get('http://k1d.local/api/comment', { responseType: 'json' }).then(function (res) {
        self.comments = res.data.data
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
.comments .posted-comments { max-height: 550px; background-color: transparent; overflow-y: auto; padding-top: 5px; padding-right: 60px; padding-left: 10px; box-sizing: border-box; }
.comments .posted-comments .comment { margin-bottom: 30px; }
.comments .posted-comments .comment .info {  }
.comments .posted-comments .comment .info .buttons { display: inline; vertical-align: top; }
.comments .posted-comments .comment .info .buttons .small-btn { height: 25px; width: 35px; font-size: 15px; text-align: center; padding: 0; vertical-align: top; }
.admin-container .comments .posted-comments .comment .info .name { line-height: 25px; }
.comments .posted-comments .comment .info .name { font-family: 'Boston'; font-size: 20px; }
.comments .posted-comments .comment .info .name i { color: #f60000; margin: 0 5px; }
.comments .posted-comments .comment .info .name i.white { color: #212121; }
.comments .posted-comments .comment .info .date { float: right; }
.comments .posted-comments .comment .text { margin-top: 30px; font-size: 17px; }
</style>