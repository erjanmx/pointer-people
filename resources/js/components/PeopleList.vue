<template>
  <div class="wrapper">
    <transition-group name="list-complete" tag="p">
      <div v-for="person in people" v-bind:key=person.id class="card list-complete-item">
        <PersonDetails :person="person"/>
      </div>
    </transition-group>
    <rotate-loader :loading="loading"></rotate-loader>
  </div>
</template>

<script>
  import PersonDetails from './PersonDetails.vue'
  import RotateLoader from 'vue-spinner/src/PulseLoader.vue'

  export default {
    props: ['people', 'loading'],
    components: {
      PersonDetails, RotateLoader,
    }
  }
</script>
