<template>
  <div>
    <AdminNav />
    
    <div class="admin-container">
      <div class='notify mb-20' :class="notifyType" v-if="notifyShow"><div class='icon'></div><div class='text'>{{ notifyMsg }}</div><div class='close'><i @click="hideNotify"></i></div></div>
      <label>UPDATE NUMBER</label>
      <input type="text" class="input" name="number" v-model="update.number">

      <label>UPDATE DATE</label>
      <input type="text" class="input" name="date" v-model="update.date">
      
      <label>UPDATE DESCRIPTION</label>
      <textarea rows="10" name="desc" v-model="update.desc"></textarea>

      <div class="mt-20"><iframe width='800' height='450' :src="'https://www.youtube.com/embed/' + update.video" frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe></div>
      <div class="images-container mt-20">
        <div></div>
        <div class='image-wrapper' v-for="(img, index) in update.images" :key="index" :class="{'deleted': img.deleted}" ><img :src="'http://k1d.local/' + img.img"><span v-if="!img.deleted" @click="rdImg(index, true)">Delete</span><span v-else @click="rdImg(index, false)">Undo</span></div>
      </div>

      <div class="mt-20">
        <button type="button" @click="updateVideo">Update video</button>

        <input type="file" ref="uploadImages" class="hidden" @change="processImages($event)" multiple>
        <button type="button" @click="uploadImages">Add images</button>

        <button class="floatr" @click="editUpdate">Edit update</button>
      </div>
    </div>
  </div>
</template>

<script>
import AdminNav from '../common/AdminNav'
import axios from 'axios'

export default {
  name: 'EditUpdate',
  data () {
    return {
      token: '',
      notifyShow: false,
      notifyType: 'success',
      notifyMsg: '',
      update: {},
      images: [],
      id: null
    }
  },
  created () {
    this.token = window.localStorage.getItem('token')
    this.id = this.$route.params.id
    this.getUpdate()
  },
  methods: {
    hideNotify () {
      this.notifyShow = false
      this.notifyType = 'success'
      this.notifyMsg = ''
    },
    showNotify (type, msg) {
      this.notifyShow = true
      this.notifyType = type
      this.notifyMsg = msg
    },
    rdImg (index, bool) {
      this.update.images[index].deleted = bool
      this.$forceUpdate()
    },
    editUpdate () {
      let self = this
      if(this.update.number !== '' && this.update.date !== '' && this.update.desc !== '') {
        var params = new FormData()
        params.append('token', this.token)
        params.append('number', this.update.number)
        params.append('desc', this.update.desc)
        params.append('date', this.update.date)
        params.append('video', this.update.video)

        if(this.images.files !== undefined && this.images.files.length > 0) {
          for(let i = 0; i < this.images.files.length; i++) {
            params.append('upload-' + i, this.images.files[i])
          }          
        }

        let deletedImages = []
        this.update.images.forEach(function(img) {
          if(img.deleted === true) {
            deletedImages.push(img.img)
          }
        })
        let images = deletedImages.join(";")
        if(images !== '') {
          params.append('delete', images)
        }
        const config = { headers: { 'Content-Type': 'multipart/form-data' } }
        const url = 'http://k1d.local/api/editupdate/' + this.id
        axios.post(url, params, config).then(function (res) {
          self.checkToken(res)
          self.updateData(res)
          self.showNotify('success', 'Updated successfully !')
          self.images = []
        }).catch(function (error) {
          self.showNotify('error', 'There was an error !')
        })
      } else {
        alert("All fields need to be fulfiled !")
      }
    },
    processImages (event) {
      this.images = event.target
    },
    uploadImages () {
      this.$refs.uploadImages.click();
    },
    updateVideo () {
      let url = prompt("Enter a YouTube video URL.");
      if(this.matchYoutubeUrl(url)) {
        this.update.video = this.youtube_parser(url)
      } else {
        this.updateVideo();
      }
    },
    getUpdate () {
      let self = this
      axios.get('http://k1d.local/api/update/' + this.id, { responseType: 'json' }).then(function (res) {
        self.updateData(res)
      }).catch(function (error) {
        console.log(error)
      })
    },
    updateData (res) {
      let d = res.data.data
      let nr = d.images.map(obj => {
        return {
          img: obj,
          deleted: false
        }
      })
      d.images = nr
      this.update = d
    },
    matchYoutubeUrl (url) {
      let p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
      if(url.match(p)){
          return url.match(p)[1];
      }
      return false;
    },
    youtube_parser (url) {
      let regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
      let match = url.match(regExp);
      return (match&&match[7].length==11)? match[7] : false;
    },
    checkToken (res) {
      if(res.data.status === false && res.data.msg === "Permission denied. Invalid token !") {
        this.$router.push({ name: 'Logout'})
        return false
      } else {
        return true
      }
    }
  },
  components: {
    AdminNav
  }
}
</script>

<style scoped>
</style>
