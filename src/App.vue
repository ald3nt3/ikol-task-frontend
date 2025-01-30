<script setup>
  import CoordinatesForm from "@/components/CoordinatesForm.vue"
</script>

<template>
  <header>
    <h1>Distance Checker</h1>
    <p><i>Check distance between two geographic coordinates.</i></p>
  </header>

  <main>
    <CoordinatesForm/>
  </main>
</template>

<style scoped>
header {
  line-height: 1.5;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

header {
  margin-bottom: 4rem;
  position: relative;
}
header h1 {
  color: var(--color-vue);
  margin-bottom: 1rem;
}

.logo {
  margin: 0 2rem 0 0;
}

header .wrapper {
  display: flex;
  place-items: flex-start;
  flex-wrap: wrap;
}
</style>
