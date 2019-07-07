<template>
  <a class="wrap">
    <img class="img" v-bind:src="getAvatarUrl(person)"/>
    <div class="description-layer">
      <span class="description">
        <div class="description-contact">{{ person.email | lowercase }}</div>
      </span>
    </div>

    <div>{{ person.name }}</div>
  </a>
</template>

<script>
  export default {
    props: ['person'],
    methods: {
        getAvatarUrl: function (person) {
            return 'https://api.adorable.io/avatars/285/' + person.id + '.png';
        }
    },
    filters: {
      lowercase: function (value) {
        return value.toLowerCase();
      }
    },
  }
</script>
