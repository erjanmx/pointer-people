<template>
    <img class="flag" :title="country.name" v-bind:src="getCountryFlagUrl(country.code)">
</template>

<script>
    export default {
        props: ['country'],
        methods: {
            getCountryFlagUrl(countryCode) {
                return countryCode ? `https://www.countryflags.io/${countryCode}/flat/32.png` : ''
            }
        },
    }
</script>
