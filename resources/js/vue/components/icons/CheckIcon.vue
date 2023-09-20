<template>
  <div>
    <svg :style="styles" width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M4.2439 9.36585L0 5.12195L1.53659 3.58537L4.2439 6.21951L10.4634 0L12 1.53659L4.2439 9.36585Z" fill="#007DEB"/>
    </svg>
  </div>
</template>

<script>
export default {
  name: "CheckIcon",
  props: {
    styles: {
      type: Object,
      default: () => {}
    }
  }
}
</script>
