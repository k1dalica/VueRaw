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
  name: 'Studio',
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
