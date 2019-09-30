<template>
  <div id="app">
    <div class="search-wrapper">
      <input type="text" v-model="searchText" placeholder="Search..."/>
      <div v-show="!loading" class="info">
        {{ filteredList.length }} / {{ peopleList.length }}
      </div>
      <label>Search:</label>
    </div>
    <PeopleList :people="filteredList" :loading="loading"/>
  </div>
</template>

<script>
import axios from 'axios';
import Person from '../person';
import fakeData from '../data.json'

import PeopleList from './PeopleList.vue'

export default {
  name: 'app',
  data () {
    return {
      searchText: '',
      peopleList : [],
      loading: true,
    }
  },
  mounted: function () {
    // set filter on load if provided
    if (this.$route && this.$route.query.s) {
      this.searchText = this.$route.query.s;
    }
  },
  created: function () {
    this.fetchPeople();
  },
  computed: {
    filteredList() {
      return this.peopleList.filter(person => {
        let searchText = this.searchText.toLowerCase();

        return person.name.toLowerCase().includes(searchText) ||
          person.email.toLowerCase().includes(searchText) ||
          person.team.toLowerCase().includes(searchText) ||
          person.position.toLowerCase().includes(searchText) ||
          person.country.name.toLowerCase().includes(searchText) ||
          person.skills.join(' ').toLowerCase().includes(searchText);
      })
    }
  },
  watch: {
    searchText: function (val) {
      let p = val.length ? `?s=${val}` : '';
      this.$router.replace(p);
    },
  },
  methods: {
    loadData(data) {
      this.peopleList = data.map(row =>
        new Person(
          row.id,
          row.name,
          row.avatar,
          row.email,
          row.bio,
          row.team,
          row.position,
          row.countryCode,
          row.skills,
        )
      );
      this.loading = false;
    },
    fetchPeople() {
      axios.get('/users')
        .then((response)  =>  {
          this.loadData(response.data.data)
        }, (error)  =>  {
          this.loadData(fakeData.data)
        })
    },
  },
  components: {
    PeopleList,
  }
}
</script>

<style lang="scss">
  @import './assets/app';
</style>
