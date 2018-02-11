<template>
  <div class='update noselect'>
		<div class='update-info'>
			<div class='info'>
				<span class='name'>{{ update.number }}</span>
				<span class='date'>{{ update.date }}</span>
			</div>
			<div class='text'>{{ update.desc }}</div>
		</div>
		<div class='relative-container'>
			<div class="view-mode" v-if="viewMode">
        <div class="image-container" ref="box">
				  <div class="image-wrapper" ref="imageContainer" :style="{ top: image.T + 'px', left: image.L + 'px' }">
            <img :src="'http://k1d.local' + openedImage" :style="{ width: image.W + 'px' }">
          </div>
				</div>
        <Slider :slider="slider" @zoomchange="zoomChange" />
        <div class="close" @click="closeImage">X</div>
			</div>

			<div class='video-wrapper'>
				<div class='video-container'>
				<iframe width='560' height='315' :src="'https://www.youtube.com/embed/' + update.video + '?rel=0&amp;controls=1&amp;showinfo=0'" frameborder='0' allowfullscreen></iframe>
				</div>
			</div>
			<div class='update-gallery'>
				<div class='gallery-list'>
					<div v-for="(image, index) in update.images" :key="index" class='image' @click="viewImage(image)">
						<img :src="'http://k1d.local' + image">
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Slider from '../updates/Slider'
import $ from "jquery";

export default {
  name: 'Update',
	props: ['update'],
  data () {
    return {
			viewMode: false,
			openedImage: '',
      el: null,
			box: {
        W: 0,
        H: 0,
        AR: 0
			},
			image: {
        W: 0,
        H: 0,
        T: 0,
        L: 0,
        trueW: 0,
        trueH: 0,
        AR: 0,
        maxW: 0,
        maxH: 0,
        maxL: 0,
        maxT: 0
			},
			slider: {
				percent: 0,
        text: 0,
        T: 212,
        minPercent: 0
      },
      position: {
        L: 50,
        T: 50,
      }
    }
  },
  mounted () {
  },
  methods: {
    onScroll (e) {
      e.preventDefault(); 
      let delta = (event.wheelDelta) ? event.wheelDelta : -1 * event.deltaY
      let l = (delta < 0) ? this.slider.T + 5 : this.slider.T - 5
      l = (l < 0) ? l = 0 : l
      l = (l > 212) ? l = 212 : l
      this.zoomChange (l, 212)
  	},
    zoomChange (n, H) {
      let nn = H - n
      this.slider.T = n
      let p = Math.round(nn / (H / 100))
      let t = Math.round(((300 - this.slider.minPercent) / 100) * p) + this.slider.minPercent
      this.slider.text = t
      let w = Math.round((this.image.trueW / 100) * t)
      this.calcImagePos()
      this.resizeImage(w)
      this.reposImage()
    },
    calcImagePos () {
      let l = this.image.L * (-1) + (this.box.W / 2)
      let nl = l / (this.image.W / 100)
      this.position.L = nl

      let t = this.image.T * (-1) + (this.box.H / 2)
      let nt = t / (this.image.H / 100)
      this.position.T = nt
    },
    reposImage () {
      let halfW = this.box.W / 2
      let a = (((this.image.W / 100) * this.position.L) - halfW) * (-1);
      this.image.L = this.checkLeft(a)

      let halfH = this.box.H / 2
      let b = (((this.image.H / 100) * this.position.T) - halfH) * (-1);
      this.image.T = this.checkTop(b)
    },
    checkLeft (l) {
      if (this.image.W > this.box.W) {
        if(l > 0) {
          l = 0
        }
        if(l < (this.box.W - this.image.W)) {
          l = this.box.W - this.image.W
        }
      } else {
        l = (this.box.W - this.image.W) / 2
      }
      return l
    },
    checkTop (t) {
      if(this.image.H > this.box.H) {
        if(t > 0) {
          t = 0
        }
        if(t < (this.box.H - this.image.H)) {
          t = this.box.H - this.image.H
        }
      } else {
        t = (this.box.H - this.image.H) / 2
      }
      return t
    },
    dragElement (elmnt) {
      let self = this
      let pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0
      
      elmnt.onmousedown = dragMouseDown

      function dragMouseDown(e) {
        e = e || window.event
        pos3 = e.clientX
        pos4 = e.clientY
        document.onmouseup = closeDragElement
        document.onmousemove = elementDrag
      }

      function elementDrag(e) {
        e = e || window.event
        pos1 = pos3 - e.clientX
        pos2 = pos4 - e.clientY
        pos3 = e.clientX
        pos4 = e.clientY
        
        if (self.image.W > self.box.W) {
          let l = elmnt.offsetLeft - pos1
          self.image.L = self.checkLeft(l)
        }

        if (self.image.H > self.box.H) {
          let t = elmnt.offsetTop - pos2
          self.image.T = self.checkTop(t)
        }
      }

      function closeDragElement() {
        document.onmouseup = null
        document.onmousemove = null
      }
    },
		viewImage (image) {
			this.viewMode = true
			this.openedImage = image
      this.$forceUpdate()
      this.$nextTick(() => {
          this.firstTimeCalculate()
      })
      
		},
		resetData () {
      this.box = {
        W: 0,
        H: 0,
        AR: 0
      }
			this.image = {
        W: 0,
        H: 0,
        T: 0,
        L: 0,
        trueW: 0,
        trueH: 0,
        AR: 0,
        maxW: 0,
        maxH: 0,
        maxL: 0,
        maxT: 0
      }
			this.slider = {
        percent: 0,
        text: 0,
        T: 212,
        minPercent: 0
      }
      this.position = {
        L: 50,
        T: 50,
      }
    },
		closeImage () {
			this.viewMode = false
			this.openedImage = ''
		},
    firstTimeCalculate () {
      this.resetData()
      this.getBoxSize()
      this.getImageTrueSize()
      this.$refs.box.addEventListener('wheel', this.onScroll);
      this.dragElement(this.$refs.imageContainer)
    },
    recalculate () {
      
    },
    getImageTrueSize () {
      let self = this
      let img = new Image()
      img.onload = function() {
        self.image.trueW = img.width
        self.image.trueH = img.height
        self.image.maxW = img.width * 3
        self.image.maxH = img.height * 3
        self.image.AR = img.width / img.height

        let size = self.box.W
        let ar = 'W'
        if(self.box.AR > self.image.AR) {
          size = self.box.H * self.image.AR
          ar = 'H'
        }
        self.resizeImage(size)
        self.recenterImage(ar)
      }
      img.src = 'http://k1d.local' +this.openedImage
    },
    getBoxSize () {
      this.el = this.$refs.imageContainer
      this.box.W = this.$refs.box.clientWidth
      this.box.H = this.$refs.box.clientHeight
      this.box.AR = this.$refs.box.clientWidth / this.$refs.box.clientHeight
    },
    setImageMaxTL () {
      this.image.maxL = this.box.W - this.image.W
      this.image.maxT = this.box.H - this.image.H
    },
    resizeImage (width) {
      this.image.W = width
      this.image.H = width / this.image.AR
      this.slider.text = Math.round(width / (this.image.trueW / 100))
      if(this.slider.minPercent === 0) {
        this.slider.minPercent = this.slider.text
      }
      this.setImageMaxTL()
    },
    recenterImage (ar) {
      if(ar === 'W') {
        this.image.T = Math.round((this.box.H - this.image.H) / 2)
        this.image.L = 0
      } else {
        this.image.T = 0
        this.image.L = Math.round((this.box.W - this.image.W) / 2)
      }
    },
    repositionImage (top, left) {

    }
  },
  components: {
	  Slider
  }
}
</script>

<style scoped>
.noselect { -webkit-touch-callout: none; -webkit-user-select: none; -khtml-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }

.update { border-top: 6px solid #212121; padding: 10px 0 25px 0; }

.update .view-mode { position: absolute; top: 0; left: 0; right: 0; margin: 0 auto; z-index: 99; background-color: #000; width: calc(100% - 100px); height: 100%; }
.update .view-mode .close { font-family: 'Arial'; color: #fff; font-size: 15px; z-index: 10; position: absolute; top: -20px; right: -20px; background-color: #000; border-radius: 20px; width: 40px; height: 40px; text-align: center; line-height: 40px; cursor: pointer; }
.update .view-mode .image-container { float: left; width: calc(100% - 150px); height: 100%; overflow: hidden; position: relative; display: inline-block; }
.update .view-mode .image-container .image-wrapper { position: absolute; top: 0; left: 0; cursor: move; cursor: grab; cursor: -moz-grab; cursor: -webkit-grab; }
.update .view-mode .image-container .image-wrapper:active { cursor: grabbing; cursor: -moz-grabbing; cursor: -webkit-grabbing; }
.update .view-mode .image-container .image-wrapper img { user-drag: none; user-select: none; -moz-user-select: none; -webkit-user-drag: none; -webkit-user-select: none; -ms-user-select: none; }

.update .update-info { margin: 0 auto; width: 800px; border-top: 1px solid #212121; border-bottom: 1px solid #212121; padding: 10px 100px 25px 100px; box-sizing: border-box; }
.update .update-info .info .name { font-size: 17px; }
.update .update-info .info .date { float: right; }
.update .update-info .text { margin-top: 40px; font-size: 14px; }
.update .post-image { margin: 20px auto; text-align: center; }
.update .video-wrapper { width: 100%; max-width: 900px; margin: 3px auto 0 auto; }
.update .video-wrapper .video-container { position: relative; padding-bottom: 56.25%; padding-top: 30px; height: 0; overflow: hidden; }
.update .video-wrapper .video-container iframe, .update .video-wrapper .video-container object, .update .video-wrapper .video-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }

.update .update-gallery { width: 100%; height: 180px; margin-top: 40px; position: relative; }
.update .update-gallery .gallery-list { white-space: nowrap; width: 100%; height: 100%; display: inline-block; }
.update .update-gallery .gallery-list .image { cursor: pointer; display: inline-block; height: 100%; border: 1px solid #212121; margin: 0 5px; box-sizing: border-box; }
.update .update-gallery .gallery-list .image img { height: 100%;}
.update .relative-container { position: relative; }
.update .relative-container .gallery-preview { display: none; justify-content: center; align-items: center; position: absolute; z-index: 5; width: 100%; height: 100%; top: 0; left: 0; margin: 0 auto; }
.update .relative-container .gallery-preview img { border: 5px solid #212121; vertical-align: top; display: block; height: 100%; }
</style>
