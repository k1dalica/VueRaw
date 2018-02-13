<template>
  <div class="admin-login">
    <form action="/admin/login/" method="POST">
      <h1>Admin login</h1>
      <!-- <div class='notify error mb-20'><div class='icon'></div><div class='text'></div><div class='close'><i onClick='$(this).parent().parent().fadeOut(250);'></i></div></div> -->
      <input type="text" placeholder="Username" class="input nbb" name="username">
      <input type="password" placeholder="Password" class="input" name="password">
      <input type='hidden' name='token' value='<?= Token::generate();?>'>
      <button>Login</button>
    </form>
  </div>
</template>

<script>

export default {
  name: 'Login',
  data () {
    return {
    }
  },
  methods: {
  },
  components: {
  }
}
</script>

<style scoped>
</style>
