<script setup>
import Modal from "@/Jetstream/Modal" 
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";
import { Link } from '@inertiajs/inertia-vue3'
import { computed, ref } from "vue";

defineProps(['phones'])

const form = useForm({
  file: null,
  title: null,
  firstname: null,
  lastname: null,
  mobile: null,
  company: null
})

const search = useForm({
  name: null,
  mobile: null
})

const fileheaders = ref('')

const getHeaders = computed(() => {
  if(fileheaders.value === '') return false
  return fileheaders.value.split(',')
})

const modalToggle = ref(false)

function onSubmit () {
  form.post(route('phone.store'))
}

function onFileChange (file) {
  form.file = file

  const reader = new FileReader()
  reader.onload = (e) => {
    let value = e.target.result
    fileheaders.value = value.split("\r\n")[0]
  }

  reader.readAsText(form.file)
}

function onDelete (id) {
  if (confirm("Are you sure you want to delete this record?") == true) {
    Inertia.delete(route('phone.destroy',id))
  } 
}

function onSearch() {
  search.get(route('phone.index'))
}
</script>

<template>
  <div class="grid grid-cols-3 gap-3">
    <div class="flex flex-col gap-1">
      <label for="name">Name:</label>
      <input type="text" v-model="search.name" @change="onSearch">
    </div>
    <div class="flex flex-col gap-1">
      <label for="mobile">Mobile:</label>
      <input type="text" v-model="search.mobile" @change="onSearch">
    </div>
    <div class="w-1/4 button flex flex-col justify-end">
      <button class="px-3 py-2 capitalize bg-green-600 text-white" @click="modalToggle = true">Import CSV</button>
    </div>
  </div>
  <div>
    <table class="table-auto">
      <thead>
        <tr>
          <th>Title</th>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Mobile Number</th>
          <th>Company</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="phone in phones" :key="phone.id">
          <td>{{ phone.title }}</td>
          <td>{{ phone.firstname }}</td>
          <td>{{ phone.lastname }}</td>
          <td>{{ phone.mobile }}</td>
          <td>{{ phone.company }}</td>
          <td class="flex gap-2">
            <Link class="text-blue-600" :href="route('phone.edit',phone.id)">Edit</Link>
            <button @click="onDelete(phone.id)" class="text-red-600">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <modal :show="modalToggle" @close="modalToggle = false">
    <div class="p-5 flex flex-col gap-3">
      <input type="file" name="" @input="onFileChange($event.target.files[0])">
      <table v-if="getHeaders">
        <thead>
          <tr>
            <th class="text-left">Column Headers</th>
            <th class="text-left">New Values</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Title</td>
            <td>
              <select name="title" v-model="form.title">
                  <option v-for="(header, key) in getHeaders" :key="key" :value="key">{{ header }}</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>First Name</td>
            <td>
              <select name="firstname" v-model="form.firstname">
                  <option v-for="(header, key) in getHeaders" :key="key" :value="key">{{ header }}</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Last Name</td>
            <td>
              <select name="lastname" v-model="form.lastname">
                  <option v-for="(header, key) in getHeaders" :key="key" :value="key">{{ header }}</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Mobile Number</td>
            <td>
              <select name="mobile" v-model="form.mobile">
                  <option v-for="(header, key) in getHeaders" :key="key" :value="key">{{ header }}</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Company Name</td>
            <td>
              <select name="company" v-model="form.company">
                  <option v-for="(header, key) in getHeaders" :key="key" :value="key">{{ header }}</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
      <button @click="onSubmit" class="px-3 py-2 capitalize bg-green-600 text-white">Submit</button>
    </div>
  </modal>
</template>