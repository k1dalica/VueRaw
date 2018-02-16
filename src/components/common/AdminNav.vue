<template>
  <header>
    <h1>Admin Panel</h1>
    <nav>
      <ul id="menu" class="ap">
        <li><router-link :to="{ name: 'Updates' }">UPDATES</router-link></li>
        <li class="spacer"><router-link :to="{ name: 'Comments' }">COMMENTS</router-link></li>
        <li><router-link :to="{ name: 'APAbout' }">ABOUT THE GAME</router-link></li>
        <li class="spacer"><router-link :to="{ name: 'APStudio' }">STUDIO</router-link></li>
        <li><router-link :to="{ name: 'Newsletter' }">NEWSLETTER</router-link></li>
        <li class="spacer"><router-link :to="{ name: 'Home' }">VISIT WEBSITE</router-link></li>
        <li><router-link :to="{ name: 'Logout' }">LOGOUT</router-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'AdminNav',
  data () {
    return {
    }
  }
}
</script>

<style scoped>
  header { text-align: center; }
  header nav { padding: 20px 0; }
  header nav #menu { list-style: none; margin: 0; padding: 0; }
  header nav #menu li { display: inline-block; font-size: 21px; font-family: 'Boston'; color: #d5d5d7; }
  header nav #menu li a.router-link-exact-active { color: #212121; }
  header nav #menu li.spacer { margin: 0 100px; }
  header nav #menu.ap li.spacer { margin: 0 40px; }
</style>
