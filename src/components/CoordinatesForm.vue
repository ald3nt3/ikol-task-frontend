<script setup>
import Group from './Group.vue'
import { ref, reactive, computed } from 'vue'
import axios from 'axios'
import CoordinateInput from '@/components/CoordinateInput.vue'

const a = reactive({
  lat: undefined,
  long: undefined,
})
const b = reactive({
  lat: undefined,
  long: undefined,
})
const result = reactive({
    km: undefined,
    m: undefined,
})

const resultRefEl = ref(null)
const queryError = ref(false)

const resultNotEmpty = computed(() => {
  return result.km !== undefined && result.m !== undefined
})

async function handleSubmit() {
  const response = await axios
    .post(
      'http://localhost/ikol-task-backend/',
      {
        lat1: a.lat,
        lon1: a.long,
        lat2: b.lat,
        lon2: b.long,
      },
      {
        headers: {
          'Content-Type': 'application/json',
        },
      },
    )
    .then((response) => {
      result.km = response.data.distance_km // Extract distance from response
      result.m = response.data.distance_m
      resultRefEl.value?.scrollIntoView({ behavior: 'smooth' })
      queryError.value = false
    })
    .catch((err) => {
      queryError.value = true
    })
}
</script>

<template>
  <form @submit.prevent="handleSubmit">
    <div id="fields">
      <Group title="Point A">
        <CoordinateInput id="latA" label="Latitude of point A" coordinateType="latitude" v-model="a.lat"/>
        <CoordinateInput id="longA" label="Longitude of point A" coordinateType="longitude" v-model="a.long"/>
      </Group>
      <Group title="Point B">
        <CoordinateInput id="latB" label="Latitude of point B" coordinateType="latitude" v-model="b.lat"/>
        <CoordinateInput id="longB" label="Longitude of point B" coordinateType="longitude" v-model="b.long"/>
      </Group>
    </div>
    <button type="submit">Check distance</button>
    <span v-if="resultNotEmpty" ref="resultRefEl" id="result"
      >{{ result.km }}<span class="unit">km</span> {{ result.m }}<span class="unit">m</span></span
    >
    <span v-if="queryError" id="query-error"
      >An error occured during data fetching</span
    >
  </form>
</template>

<style>
form,
#fields {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}
@media (min-width: 768px) {
  #fields {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }
}
#result {
  color: var(--color-vue);
  font-size: 6rem;
  margin: 0px auto 0px auto;
  line-height: 8rem;
  text-align: center;
}
#query-error {
    color: rgb(232, 104, 104);
    text-align: center;
}
.unit {
  font-size: 3rem;
}
</style>
