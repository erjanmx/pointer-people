<template>
  <a class="wrap">
    <img :alt="person.name" class="img" v-bind:src="person.avatar" @error="imgUrlAlt"/>
    <PersonCountry :country="person.country" />
    <div class="description-layer">
        <PersonCountry :country="person.country" />
        <span class="description">
            <div class="description-position">{{ person.team }}</div>
            <div class="description-position">{{ person.position }}</div>
            <div class="description-contact">{{ person.email | lowercase }}</div>
            <div v-show="person.bio" >
                <hr/>
                <div class="description-about">{{ person.bio }}</div>
            </div>
            <div v-show="person.skills.length" >
                <hr />
                <div class="description-skills">{{ getPersonSkills(person) }}</div>
            </div>
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
        getPersonSkills: function (person) {
            return person.skills.length ? 'Top skills: ' + person.skills.join(', ') : '';
        },
        imgUrlAlt(event) {
            event.target.src = "https://via.placeholder.com/250x250?text=No picture found";
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
