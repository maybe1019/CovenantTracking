<template>
<div id="app">
      <form id="compliance_form" class="dark:text-white text-lg opacity-70" enctype="multipart/form-data" style="min-height: 300px" @submit.prevent="saveData()">
      <div class="mb-8 space-y-4"></div>
        <h1 class="text-90 font-normal text-xl md:text-2xl mb-3">Create Compliance</h1>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="name-create-organization-text-field" class="inline-block pt-2 leading-tight">CL Code <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
              <input type="text" placeholder="Name" name="clcode" v-model="compliance.clcode" class="w-full form-control form-input form-input-bordered" id="name-create-clcode-text-field" dusk="name" list="name-list" required="required"><!----><!----><!---->
            </div>
          </div>

          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="name-create-organization-text-field" class="inline-block pt-2 leading-tight">ISIN <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
              <div class="" v-for="item in compliance.isin">
                <input v-model="item.value" placeholder="Enter ISIN" type="text" name="isin[]" class="w-full form-control form-input form-input-bordered" required="required">
              </div>
              <span><button @click.prevent="addInput" class="repeater">Add +</button> <button class="repeater" @click.prevent="removeIsin">Remove -</button></span>
            </div>
          </div>

          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">Document Name <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
              <input type="text" placeholder="Document Name" v-model="compliance.docName" class="w-full form-control form-input form-input-bordered" id="name-create-docName-text-field" name="docName" dusk="docName" list="name-list" required="required"><!----><!----><!---->
            </div>
          </div>

          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">Start Date <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
              <input type="date" v-model="compliance.startDate" class="form-control form-input form-input-bordered" id="name-create-organization-text-field" name="startDate" dusk="startDate" list="name-list" required="required"><!----><!----><!---->
            </div>
          </div>

          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">End Date <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
              <input type="date" v-model="compliance.endDate" class="form-control form-input form-input-bordered" id="name-create-endDate-text-field" name="endDate" dusk="endDate" list="name-list" required="required"><!----><!----><!---->
            </div>
          </div>

          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">Priority <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
            <select class="w-full form-control form-input-bordered select-box" v-model="compliance.priority" required>
              <option :value="null">Select Priority</option>
              <option value="Low">Low</option>
              <option value="Medium">Medium</option>
              <option value="High">High</option>
            </select>
          </div>
          </div>

          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">Secured <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
            <select class="w-full form-control form-input-bordered select-box" v-model="compliance.secured" required>
              <option value="secured">Secured</option>
              <option value="unsecured">Unsecured</option>
            </select>
          </div>
          </div>

          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">Inconsistency Treatment <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
              <input type="text" placeholder="Enter Inconsistency Treatment" v-model="compliance.inconsistencyTreatment" class="w-full form-control form-input form-input-bordered" id="name-create-inconsistencyTreatment-text-field" name="inconsistencyTreatment" dusk="inconsistencyTreatment" list="name-list" required="required"><!----><!----><!---->
            </div>
          </div>

          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">Client Reference <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
            <select class="w-full form-control form-input-bordered select-box" v-model="compliance.clientReference" required>
                <option value="">Select Clients</option>
                <option v-for="data in compliance.clientData" :value="data.id">{{ data.name }}</option>
            </select>
          </div>
          </div>

          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">Mail CC <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
              <input type="text" placeholder="Enter Mail CC" v-model="compliance.mailCC" class="w-full form-control form-input form-input-bordered" id="name-create-mailCC-text-field" name="mailCC" dusk="mailCC" list="name-list" required="required"><!----><!----><!---->
            </div>
          </div>


          <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">Upload Document(s) <span class="text-red-500 text-sm"></span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
              <input type="file" multiple class="w-full form-control form-input form-input-bordered" id="name-create-documentUpload-text-field" name="documentUpload[]" dusk="documentUpload" list="name-list" ref="files" @change="handleFilesUpload">
            </div>
          </div>


          <button size="lg" align="center" component="button" dusk="create-button" type="submit" class="shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900 cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 inline-flex items-center justify-center h-9 px-3 shadow relative bg-primary-500 hover:bg-primary-400 text-white dark:text-gray-900" style="    margin: 30px;"><span class="">Continue</span><!----></button>
      </div>  
    </form>
</div>
</template>
<script>
//import covenantData from '../../../../../nova-components/Newcompliance/resources/js/pages/Tool.vue';  
export default {
  name: 'app',
  data() {
    return {
      'compliance' : {
        'clcode':'',
        'isin':[{}],
        'docName':'',
        'startDate':'',
        'endDate':'',
        'priority': '',
        'secured': '',
        'inconsistencyTreatment':'',
        'clientReference':'',
        'mailCC':'',
        'clientData':'',
        'documentUpload':[],
        'files': '',
        'nextComponent':'test',
      },
    }
  },
  methods: {
    saveData() {

      let formData = new FormData();
      const config = { headers: {'Content-Type': 'multipart/form-data'}};
      for( var i = 0; i < this.files.length; i++ ){
          let file = this.files[i];
          formData.append('files[' + i + ']', file);
      }
      formData.append('clcode', this.compliance.clcode);
      formData.append('isin', JSON.stringify(this.compliance.isin));
      formData.append('docName', this.compliance.docName);
      formData.append('startDate', this.compliance.startDate);
      formData.append('endDate', this.compliance.endDate);
      formData.append('priority', this.compliance.priority);
      formData.append('secured', this.compliance.secured);
      formData.append('inconsistencyTreatment', this.compliance.inconsistencyTreatment);
      formData.append('clientReference', this.compliance.clientReference);
      formData.append('mailCC', this.compliance.mailCC);
      Nova.request().post('/nova-vendor/newcompliance/store',formData,config)
      .then(
          response => {
            if(response.data == 'success') {
              this.$emit('clicked', 'covenantData')
            }
          }
      )
    },
    addInput() {
      this.compliance.isin.push({});
    },
    removeIsin() {
      this.compliance.isin.pop({});
    },
    fetchClients(){
      Nova.request().post('/nova-vendor/newcompliance/fetchClients')
      .then(response => {
          this.compliance.clientData = response.data;
          
      });
    },

    handleFilesUpload(){
        this.files = this.$refs.files.files;
    },
  },
  created:function(){
   this.fetchClients();
  },
  mounted() {
    //
  },
}
</script>

<style>
/* Scoped Styles */
</style>
