<template>
  <section class="comments">
    <div id="commentForm">
      <div class="comments-info">
        <span>COMMENTS</span>
        <span class="floatr">{{comments.length}}</span>
      </div>
      <div class="comments-label">
        <label>POST A COMMENT</label>
        <small>PRESS ENTER TO POST (1000 ch max)</small>
        <button class="post-button" @click="postComment"></button>
      </div>
      <div class="post-comment">
        <div class="input-wrapper">
          <label>NAME</label>
          <input type="text" class="input" id="name" maxlength="40" v-model='name'>
        </div>
        <textarea rows="12" maxlength="1000" id="comment" v-model='text'></textarea>
      </div>
    </div>

    <div class="posted-comments" id="comment-list">
      <div class='comment' v-for="cmnt in postedcomments">
        <div class='info'>
          <span class='name'>{{cmnt.name}}</span>
          <span class='date'>{{cmnt.date}}</span>
        </div>
        <div class='text'>{{cmnt.text}}</div>
      </div>

      <div class='comment' v-for="(comment, index) in comments" :key="index">
        <div class='info'>
          <span class='name'>{{comment.name}}
            <i class='fa fa-heart' :class="{'red': comment.iliked, 'white': !comment.iliked, 'ponter': !comment.mycomment }" @click="like(index)" aria-hidden='true'></i> <font>{{comment.likes}}</font>";
          </span>
          <span class='date'>{{comment.date}}</span>
        </div>
        <div class='text'>{{comment.text}}</div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  name: 'Comments',
  data () {
    return {
      name: '',
      text: '',
      comments: [],
      postedcomments: [],
      size: 0
    }
  },
  created() {
    this.getComments()
  },
  methods: {
    like (index) {
      let self = this
      let comment = this.comments[index]
      if (!comment.mycomment) {
        let ns = !comment.iliked
        self.comments[index].iliked = ns
        self.comments[index].likes = (ns === false) ? comment.likes - 1 : comment.likes + 1
        
        let params = new URLSearchParams()
        params.append('id', comment.id)
        params.append('like', ns)
        axios.put('http://k1d.local/api/comments', params).then(function (res) {
        
        }).catch(function (error) {
          console.log(error)
        })
      }
    },
    postComment () {
      let self = this
      let params = new URLSearchParams()
      params.append('name', this.name)
      params.append('text', this.text)
      axios.post('http://k1d.local/api/comments', params).then(function (res) {
        if(res.data.status) {
          self.name = ''
          self.text = ''
          self.postedcomments.push(res.data.data)
        } else {
          
        }
      }).catch(function (error) {
        console.log(error)
      });
    },
    getComments () {
      let self = this
      axios.get('http://k1d.local/api/comments', { responseType: 'json' }).then(function (res) {
        self.comments = res.data.data
        self.size = res.data.data.length
      }).catch(function (error) {
        console.log(error)
      });
    }
  }
}
</script>

<style scoped>
  .comments { width: 800px; border-top: 1px solid #848285; margin-top: 25px; padding-top: 25px; }
  .comments .comments-info { font-size: 17px; font-weight: 300; }
  .comments .comments-label { padding-top: 35px; position: relative; }
  .comments .comments-label small { font-size: 11px; color: #212121; position: absolute; bottom: 0; right: 0; }
  .comments .comments-label .post-button { cursor: pointer; width: 85px; height: 47px; background-color: transparent; border: none; outline: none; border-radius: 10px; position: absolute; bottom: 25px; right: 120px; background-image: url(./../../assets/images/post.png); background-repeat: no-repeat; }
  .comments .post-comment { margin-top: 5px; }
  .comments .post-comment .input-wrapper { height: 50px; border: 1px solid #212121; position: relative; }
  .comments .post-comment .input-wrapper label { position: absolute; top: 0; right: 15px; bottom: 0; margin: auto 0; font-size: 17px; line-height: 50px; }
  .comments .post-comment .input-wrapper .input { width: 100%; height: 50px; border: none; outline: none; background-color: transparent; color: #212121; font-size: 17px; padding: 0 75px 0 15px; box-sizing: border-box; }
  .comments .post-comment textarea { background-color: transparent; border: 1px solid #212121; border-top: none; outline: none; padding: 10px 15px; line-height: 20px; font-size: 17px; color: #212121; width: 100%; box-sizing: border-box; }

  .comments .posted-comments { max-height: 550px; background-color: transparent; overflow-y: auto; padding-top: 5px; padding-right: 60px; padding-left: 10px; box-sizing: border-box; }
  .comments .posted-comments .comment { margin-bottom: 30px; }
  .comments .posted-comments .comment .info {  }
  .comments .posted-comments .comment .info .buttons { display: inline; vertical-align: top; }
  .comments .posted-comments .comment .info .buttons .small-btn { height: 25px; width: 35px; font-size: 15px; text-align: center; padding: 0; vertical-align: top; }
  .comments .posted-comments .comment .info .name { font-family: 'Boston'; font-size: 20px; }
  .comments .posted-comments .comment .info .name i { color: #f60000; margin: 0 5px; }
  .comments .posted-comments .comment .info .name i.ponter { cursor: pointer; transition: all ease-out .2s; }
  .comments .posted-comments .comment .info .name i.ponter:hover { color: red; transition: all ease-out .2s; }
  .comments .posted-comments .comment .info .name i.white { color: #212121; }
  .comments .posted-comments .comment .info .date { float: right; }
  .comments .posted-comments .comment .text { margin-top: 30px; font-size: 17px; }
</style>
