<template>
  <div>
    <HeaderNav/>
    
    <div class="content ql-editor" v-html="content"></div>
  </div>
</template>

<script>
import TopItems from '../common/TopItems'
import HeaderNav from '../common/HeaderNav'

export default {
  name: 'About',
  data () {
    return {
      content: ''
    }
  },
  methods: {
  },
  components: {
    HeaderNav,
    TopItems
  }
}
</script>

<style scoped>
</style>
