<template>
  <div id="selCovenant">
  	<h1>Select Covenant</h1>
  	<form>
  		<div class="bg-white dark:bg-gray-800 rounded-lg shadow">
  		  <div class="field-wrapper flex flex-col border-b border-gray-100 dark:border-gray-700 md:flex-row" index="0">
            <div class="px-6 md:px-8 mt-2 md:mt-0 w-full md:w-1/5 md:py-5">
              <label for="" class="inline-block pt-2 leading-tight">Select Covenant <span class="text-red-500 text-sm">*</span>
              </label>
            </div>
            <div class="mt-1 md:mt-0 pb-5 px-6 md:px-8 w-full md:w-3/5 md:py-5">
	            <select class="w-full form-control form-input-bordered select-box" v-model="covenantDetails.selCovenant" @change.prevent="fetchSubtypes" required>
	                <option value="">Select Covenants</option>
	                <option v-for="data in covenantDetails.covenant" :value="data.type">{{ data.type }}</option>
	            </select>
          	</div>
          </div>
          <div class="overflow-hidden overflow-x-auto relative">
   <table class="w-full table-default" cellpadding="0" cellspacing="0" data-testid="resource-table" v-if="covenantDetails.covenantInfo.length>0">
      <thead class="bg-gray-50 dark:bg-gray-800">
         <tr>
            <th class="td-fit uppercase text-xxs text-gray-500 tracking-wide pl-5 pr-2 py-2"><span class="sr-only">Selected Resources</span></th>
            <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"><span>Covenant Sub Type</span></th>
            <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"><span>Description</span></th>
            <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"><span>Frequency</span></th>
            <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"><span>Target Value</span></th>
            <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"><span>Due Date</span></th>
            <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"><span>Parameters</span></th>
            <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide py-2"><span>Covenant Details</span></th>
         </tr>
      </thead>
      <tbody>
         <tr dusk="3-row" class="group" v-for="covData in covenantDetails.covenantInfo" >
            <td class="py-2 border-t border-gray-100 dark:border-gray-700 px-2 cursor-pointer td-fit pl-5 pr-5 dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"><input type="checkbox" class="checkbox" aria-label="Select Resource 3" data-testid="clients-items-0-checkbox" dusk="3-checkbox"  :value="covData.id" v-model="covData.selectedItems"></td>
            <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
               <div class="text-left"><span class="text-90 whitespace-nowrap">{{covData.subType}}</span></div>
            </td>
            <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
               <div class="text-left"><span class="text-90 whitespace-nowrap">{{covData.description}}</span></div>
            </td>
            <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
               <div class="text-left">
                  <input type="text" placeholder="Frequency" name="clcode" class="w-full form-control form-input form-input-bordered" id="name-create-clcode-text-field" dusk="frequency" list="name-list" v-model="covData.frequency" />
               </div>
            </td>
            <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
               <div class="text-left"><span class="text-90 whitespace-nowrap">
               	<input type="text" placeholder="Target Value" name="clcode" class="w-full form-control form-input form-input-bordered" id="name-create-clcode-text-field" dusk="frequency" list="name-list" v-model="covData.targetValue"/></span></div>
            </td>
            <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
               <div class="text-left"><span><input type="date" name="duedate" class="w-full form-control form-input form-input-bordered" id="name-create-clcode-text-field" dusk="frequency" list="name-list" v-model="covData.dueDate" /></span></div>
            </td>
            <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
               <div class="text-left">
               	<span v-if="covData.covenantParameters.length<=0">NA</span>
               	<span v-if="covData.covenantParameters.length>0" v-for="param in covData.covenantParameters">
               		<select class="w-full form-control form-input-bordered select-box" v-model="covenantDetails.selectedParam" required 
               		v-if="param.type=='dropdown'">
		                <option :value="null">{{param.key}}</option>
		                <option v-for="data in param.value" :value="data">{{data}}</option>
		            </select>
               		<input v-if="param.type==input" type="text" placeholder="Paramters" name="clcode" class="w-full form-control form-input form-input-bordered" id="name-create-clcode-text-field" dusk="frequency" list="name-list" v-model="covData.covenantParameters" />
               </span>
           		</div>
            </td>
            <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">
               <div class="text-left"><span>
               	<input type="text" placeholder="Frequency" name="clcode" class="w-full form-control form-input form-input-bordered" id="name-create-clcode-text-field" dusk="frequency" list="name-list" />
               </span></div>
            </td>
         </tr>
      </tbody>
   </table>
</div>
  		</div>
  	</form> 	
  </div>
</template>
<script>
export default {
  name: 'app',
  data() {
    return {
      'covenantDetails' : {
        'covenant':'',
        'selCovenant':'',
        'covenantInfo':'',
        'selectedItems':'',
        'selectedParam':null,
      },
    }
  },
  methods: {
	fetchCovenant(){
      Nova.request().post('/nova-vendor/newcompliance/fetchCovenant')
      .then(response => {
      	console.log(response.data);
          this.covenantDetails.covenant = response.data;          
      });
    },
    fetchSubtypes(){
    	var type = this.covenantDetails.selCovenant;
		Nova.request().post('/nova-vendor/newcompliance/fetchSubtypes',{'type':type})
	      .then(response => {
	      	console.log(response.data);
	          this.covenantDetails.covenantInfo = response.data;          
	    });
    },
  },
   created:function(){
   	this.fetchCovenant();
   },
}
</script>