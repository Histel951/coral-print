<template>
  <div class="lds-dual-ring"></div>
</template>

<script>
export default {
  name: "ModalLoader"
}
</script>

<style scoped>
.lds-dual-ring {
  display: inline-block;
  width: 80px;
  height: 80px;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 46px;
  height: 46px;
  margin: 8px;
  border-radius: 50%;
  border: 6px solid #007deb;
  border-color: #007deb transparent #007deb transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

</style>
