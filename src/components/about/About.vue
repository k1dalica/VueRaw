<template>
  <div>
    <TopItems/>
    
    <HeaderNav/>
  </div>
</template>

<script>
import TopItems from '../common/TopItems'
import HeaderNav from '../common/HeaderNav'

export default {
  name: 'About',
  data () {
    return {
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
