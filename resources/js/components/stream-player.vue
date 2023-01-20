<template>
  <div class="agora-video-player" ref="player" :id="domId" v-if="appointment_type_id == 2"></div>
  <div class="agora-video-player" ref="player" :id="domId" v-else>
      <img  class="img-fluid h-100 w-100" src="/assets/images/microphone.gif" alt="">
  </div>
</template>

<script>
export default {
  name: 'stream-player',
  props: [
    'stream',
    'domId',
    'appointment_type_id',
    'id'
  ],
  mounted () {
    this.$nextTick(function () {
      if (this.stream && !this.stream.isPlaying()) {
        this.stream.play(`${this.domId}`, {fit: 'cover'}, (err) => {
          if (err && err.status !== 'aborted') {
            console.warn('trigger autoplay policy')
          }
        })
      }
    })

  },
  beforeDestroy () {
    if (this.stream) {
      if (this.stream.isPlaying()) {
        this.stream.stop()
      }
      this.stream.close()
    }
  }
}
</script>

<style>
.agora-video-player {
  height: 100%;
  width: 100%;

}

.agora-video-player div{
  background-color: transparent !important;
overflow: visible !important;

}
</style>
