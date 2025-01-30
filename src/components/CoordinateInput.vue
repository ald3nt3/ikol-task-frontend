<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    coordinateType: {
        type: String,
        default: "latitude",
    },
})
const model = defineModel()

const max = computed(() => (props.coordinateType === "longitude" ? 180 : 90))
const min = computed(() => -max.value)

const error = ref('')

const handleInput = (event) => {
    if(!event.target.value) error.value = "This value cannot be empty"
    else if(event.target.value > max.value ) error.value = "This value cannot be greater than " + max.value
    else if(event.target.value < min.value ) error.value = "This value cannot be lower than " + min.value
    else error.value = ""
}
</script>

<template>
  <label :for="props.id">
    {{ props.label }}
  </label>
  <input :id="props.id" type="number" v-model="model" required :min="min" :max="max" step="0.0000001" @input="handleInput"/>
  <span class="error" v-if="error">{{ error }}</span>
</template>

<style>
.error {
    font-size: 0.75rem;
    color: rgb(232, 104, 104);
    margin-top: -0.5rem;
    margin-bottom: 1rem;
}
</style>
