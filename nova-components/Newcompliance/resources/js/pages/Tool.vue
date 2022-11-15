<template>
  <div id="app">
    <component v-bind:is="this.componentLoad" @clicked="updatecomponent"/>
  </div>
</template>

<script>
import covenantData from '../../../../../nova-components/Newcompliance/resources/js/pages/Selectcov.vue';  
import overviewData from '../../../../../nova-components/Newcompliance/resources/js/pages/overview.vue';
export default {
  //el: '#app',
  name: 'app',
  components: {
    covenantData,
     overviewData,
  },
  props: ['componentLoad'],
  data() {
    return {
      'componentLoad':'covenantData',
    }
  },
  methods: {
    updatecomponent(value) {
        //const {value} = event.target;
        this.componentLoad = value;
    }
  },
  
  created:function(){
   //this.fetchClients();
  },
  mounted() {
    //
  },
}
</script>

<style>
/* Scoped Styles */
</style>
