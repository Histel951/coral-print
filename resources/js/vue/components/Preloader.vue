<template>
  <svg :style="styles" width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_5137_13392)">
      <path class="c-anim"
            d="M55.3073 76.9552C63.4424 73.5855 70.2383 67.6257 74.641 60L62.5204 53.0022C58.0246 60.7724 49.6228 66 40 66C25.6406 66 14 54.3594 14 40C14 25.6406 25.6406 14 40 14C49.6228 14 58.0246 19.2276 62.5204 26.9978L74.641 20C70.2383 12.3743 63.4424 6.4145 55.3073 3.04483C47.1722 -0.324837 38.1526 -0.916016 29.6472 1.36298C21.1419 3.64198 13.6262 8.66379 8.26586 15.6496C2.9055 22.6353 0 31.1946 0 40C0 48.8054 2.9055 57.3647 8.26587 64.3505C13.6262 71.3362 21.1419 76.358 29.6472 78.637C38.1526 80.916 47.1722 80.3249 55.3073 76.9552Z"
            fill="#007DEB"/>
      <circle cx="40" cy="40" r="4" fill="#007DEB"/>
      <rect class="m-anim" x="39" y="19" width="2" height="21" fill="#007DEB"/>
      <g class="h-anim">
        <rect x="26" y="41" width="2" height="14" transform="rotate(-90 26 41)" fill="#007DEB"/>
      </g>
    </g>
    <defs>
      <clipPath id="clip0_5137_13392">
        <rect width="80" height="80" fill="white"/>
      </clipPath>
    </defs>
  </svg>

</template>

<script>
export default {
  name: "Preloader",
  props: {
    styles: {
      type: Object,
      default: () => {}
    }
  }
}
</script>

<style lang="scss" scoped>
@keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  25% {
    -webkit-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
  }

  50% {
    -webkit-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    transform: rotate(180deg);
  }

  75% {
    -webkit-transform: rotate(270deg);
    -ms-transform: rotate(270deg);
    -moz-transform: rotate(270deg);
    -o-transform: rotate(270deg);
    transform: rotate(270deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

.c-anim {
  transform-origin: center;
  animation: spin 1s linear infinite;
  -webkit-animation: spin 1s linear infinite;
  -moz-animation: spin 1s linear infinite;
  -o-animation: spin 1s linear infinite;
}

.m-anim {
  transform-origin: center;
  animation: spin 1s linear infinite;
  -webkit-animation: spin 1s linear infinite;
  -moz-animation: spin 1s linear infinite;
  -o-animation: spin 1s linear infinite;
}

.h-anim {
  transform-origin: center;
  animation: spin 1s linear infinite;
  -webkit-animation: spin 1s linear infinite;
  -moz-animation: spin 1s linear infinite;
  -o-animation: spin 1s linear infinite;
}
</style>
