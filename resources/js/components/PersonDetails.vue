<template>
  <a class="wrap">
    <img :alt="person.name" class="img" v-bind:src="getAvatarUrl(person)"/>
    <PersonCountry :country="person.country" />
    <div class="description-layer">
        <PersonCountry :country="person.country" />
        <span class="description">
            <div class="description-position">{{ person.team }}</div>
            <div class="description-position">{{ person.position }}</div>
            <div class="description-contact">{{ person.email | lowercase }}</div>
            <hr/>
            <div class="description-about">{{ person.bio }}</div>
        </span>
    </div>

    <div>{{ person.name }}</div>
  </a>
</template>

<script>
  import PersonCountry from './PersonCountry.vue'

  export default {
    props: ['person'],
    methods: {
        getAvatarUrl: function (person) {
            return person.avatar || 'https://api.adorable.io/avatars/285/' + person.id + '.png';
        }
    },
    filters: {
      lowercase: function (value) {
        return value.toLowerCase();
      }
    },
    components: {
      PersonCountry,
    },
  }
</script>
