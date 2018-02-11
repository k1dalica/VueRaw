<template>
  <div class="slider-container">
    <div class="slider-wrapper">
      <div class="zoom-wrapper">
        <div class="bar" ref="zoomBar"></div>
        <div class="point" ref="zoomScroll" :style="{ bottom: H - slider.T + 'px' }"></div>
      </div>
      <div class="text">
        <span class="zoom">ZOOM</span>
        <span>{{ slider.text }}x</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Slider',
  props: ['slider'],
  data () {
    return {
      el: null,
      H: 0
    }
  },
  mounted () {
    this.H = this.$refs.zoomBar.clientHeight - 15
    this.el = this.$refs.zoomScroll
    this.dragElement(this.el);
  },
  methods: {
    dragElement(elmnt) {
      let self = this
      let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
      
      elmnt.onmousedown = dragMouseDown;

      function dragMouseDown(e) {
        e.preventDefault()
        e = e || window.event;
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        document.onmousemove = elementDrag;
      }

      function elementDrag(e) {
        e.preventDefault()
        e = e || window.event;
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        let n = (elmnt.offsetTop - pos2)
        if(n < 0)
          n = 0
        if(n > self.H)
          n = self.H

        self.updateSlider(n)
        // elmnt.style.top = n + "px";
        // elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
      }

      function closeDragElement() {
        document.onmouseup = null;
        document.onmousemove = null;
      }
    },
    updateSlider (n) {
      this.$emit('zoomchange', n, this.H)
    }
  }
}
</script>

<style scoped>
.slider-container { z-index: 5; float: right; width: 150px; height: 100%; position: relative; border-left: 5px solid #fff; box-sizing: border-box; }
.slider-container .slider-wrapper { position: absolute; bottom: 100px; left: 0; right: 0; margin: 0 auto; width: 100%; text-align: center; }
.slider-container .slider-wrapper .zoom-wrapper { margin: 0 auto; position: relative; width: 60px; }
.slider-container .slider-wrapper .bar { width: 20px; border: 7px solid #fff; border-top: none; height: 234px; background-color: #000; box-sizing: border-box; margin: 0 auto; position: relative; }
.slider-container .slider-wrapper .point { position: absolute; cursor: pointer; left: 0; bottom: 0; width: 58px; height: 20px; border-radius: 3px; background-color: #fff; border: 1px solid #000; }
.slider-container .slider-wrapper .text { color: #fff; margin-top: 20px; }
.slider-container .slider-wrapper .text span { display: block; font-weight: 600; }
.slider-container .slider-wrapper .text span.zoom { font-size: 30px; }
</style>
