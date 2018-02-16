<template>
  <div>
    <AdminNav />
    
    <div class="wrapper">
      <quill-editor :content="content"
        :options="editorOption"
        @change="onEditorChange($event)">
      </quill-editor>
      <button class="floatr">Save</button>
    </div>
  </div>
</template>

<script>
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

import AdminNav from '../common/AdminNav'
import axios from 'axios'
import { quillEditor } from 'vue-quill-editor'

export default {
  name: 'APStudio',
  data () {
    return {
      token: '',
      content: '',
      editorOption: { }
    }
  },
  created () {
    this.token = window.localStorage.getItem('token')
    this.getText()
  },
  components: {
    quillEditor
  },
  methods: {
    onEditorChange({ quill, html, text }) {
      this.content = html
    },
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
.wrapper { width: 1024px; margin: 100px auto; }
button { margin-top: 20px; }
</style>