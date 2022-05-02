<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps(['phone'])
const form = useForm({
  ...props.phone
})

function submit () {
  form.put(route('phone.update', props.phone.id))
}

</script>

<template>
  <div class="w-1/3 flex flex-col gap-2">
    <div class="flex flex-col gap-0">
      <label for="">Title:</label>
      <input type="text" v-model="form.title">
    </div>

    <div class="flex flex-col gap-0">
      <label for="">First Name:</label>
      <input type="text" v-model="form.firstname">
    </div>
    
    <div class="flex flex-col gap-0">
      <label for="">Last Name:</label>
      <input type="text" v-model="form.lastname">
    </div>
    
    <div class="flex flex-col gap-0">
      <label for="">Mobile Number:</label>
      <input type="text" v-model="form.mobile">
    </div>
    
    <div class="flex flex-col gap-0">
      <label for="">Company:</label>
      <input type="text" v-model="form.company">
    </div>

    <button @click="submit" class="py-3 px-2 bg-blue-600 text-white text-center capitalize">Submit</button>
    <Link :href="route('phone.index')" class="py-3 px-2 bg-red-600 text-white text-center capitalize">Cancel</Link>

  </div>
</template>