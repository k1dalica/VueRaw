<template>
  <div>
    <TopItems/>
    
    <HeaderNav/>

    <div class="main-logo">
      <img src="./../../assets/images/logo.png">
    </div>

    <Comments/>
    
    <Updates/>

  </div>
</template>

<script>
import TopItems from '../common/TopItems'
import HeaderNav from '../common/HeaderNav'
import Comments from '../home/Comments'
import Updates from '../updates/Updates'

export default {
  name: 'Home',
  data () {
    return {
    }
  },
  methods: {
  },
  components: {
    HeaderNav,
    TopItems,
    Comments,
    Updates
  }
}
</script>

<style scoped>
.main-logo { text-align: center; }
</style>
