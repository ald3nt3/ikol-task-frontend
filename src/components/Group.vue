<script setup>
defineProps({
  title: {
    type: String,
    required: true,
  },
})
</script>

<template>
  <fieldset>
    <legend>{{ title }}</legend>
    <slot></slot>
  </fieldset>
</template>

<style>
legend {
  position: absolute;
  top: -0.5rem;
  line-height: 1rem;
  left: 0.5rem;
  padding: 0 0.5rem;
  background-color: var(--color-background);
}
fieldset {
  position: relative;
  padding: 1.5rem 1rem 1rem 1rem;
  display: flex;
  flex-direction: column;
  border: 1px solid var(--color-border);
  background: var(--color-background);
  border-radius: 8px;
}
</style>
