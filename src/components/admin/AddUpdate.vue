<template>
  <div>
    <AdminNav />
  	
    <div class="admin-container">
      <div class='notify error mb-20'><div class='icon'></div><div class='text'></div><div class='close'><i onClick='$(this).parent().parent().fadeOut(250);'></i></div></div>
      <label>UPDATE NUMBER</label>
      <input type="text" class="input" name="number" required>

      <label>UPDATE DATE</label>
      <input type="text" class="input" name="date" required>
      
      <label>UPDATE DESCRIPTION</label>
      <textarea rows="10" name="desc" required></textarea>

      <div id="video-container" class="mt-20"></div>
      <div id="images-container" class="mt-20">
        <div id="images-new"></div>
      </div>

      <input type='hidden' name='token' value='<?= Token::generate();?>'>

      <div class="mt-20">
        <input type="hidden" name="video" id="video">
        <button type="button" onClick="addVideo();">Add video</button>

        <input type="file" id="images" name="images[]" class="hidden" multiple>
        <button type="button" onClick="$('#images').click();">Add images</button>

        <button class="floatr">Add update</button>
      </div>
    </div>
  </div>
</template>

<script>
import AdminNav from '../common/AdminNav'

export default {
  name: 'AddUpdate',
  data () {
    return {
    }
  },
  methods: {
  },
  components: {
    AdminNav
  }
}
</script>

<style scoped>
</style>
