<template>
  <div>

    <Head title="Calendar" />

    <Heading class="mb-6">Calendar abc</Heading>

    <div class="total-container">
      <Card class="calendar-wrapper" style="min-height: 300px">
        <div class="event-filter">
          <button v-for="source, index in eventSources" :key="index" :class="{ active: source.enable }"
            @click="handleFilterButtonClick(index)">{{ `${source.name} (${source.events.length})` }}</button>
        </div>
        <div class="calendar-content">
          <FullCalendar class='demo-app-calendar' :options='calendarOptions' />
        </div>
      </Card>

      <div class="event-info-wrapper">
        <div class="event-info-content" v-if="selectedData.selected">
          <Card class="event-info">
            <h3>Complience Details</h3>
            <div class="info-container">
              <div class="info-item">
                <h4>CL Code:</h4>
                <p>{{ selectedData.clcode }}</p>
              </div>

              <div class="info-item">
                <h4>Covenant Status</h4>
                <p>{{ selectedData.clcode }}</p>
              </div>

              <div class="info-item">
                <h4>Document name:</h4>
                <p>{{ selectedData.docName }}</p>
              </div>

              <div class="info-item">
                <h4>Start Date:</h4>
                <p>{{ selectedData.startDate }}</p>
              </div>

              <div class="info-item">
                <h4>Status:</h4>
                <p>{{ selectedData.status }}</p>
              </div>

              <div class="info-item">
                <h4>End Date:</h4>
                <p>{{ selectedData.endDate }}</p>
              </div>
            </div>

            <div class="info-container upload-controller">
              <div class="info-item">
                <h4>Resolution:</h4>
                <input name="resolution" v-model="resolution" placeholder="Enter Value" />
              </div>
              <div class="info-item">
                <button @click="handleUploadFileClick">Upload File</button>
                <input type="file" id="file" name="file" style="display: none;" ref="file" multiple="multiple" @change="handleSelectedFilesChange">
              </div>
            </div>

            <div class="selected-file-list">
              <p>{{ selectedFiles.length }} files selected</p>
              <div class="selected-files-container">
                <div v-for="f, index in selectedFiles" :key="index">
                  {{ f.name }}
                  <img src="/img/cross.png" alt="cross" @click="handleRemoveSelectedFile(index)">
                </div>
              </div>
            </div>

            <div class="text-area-container">
              <textarea v-model="comments" maxlength="300" placeholder="Add Comments">
              </textarea>
            </div>

            <div class="info-result">
              <h4>Result:</h4>
              <div
                class="radio-button"
                :class="{ active: infoResult === 'pass' }"
                @click="infoResult = 'pass'"
              >Pass</div>
              <div
                class="radio-button"
                :class="{ active: infoResult === 'fail' }"
                @click="infoResult = 'fail'"
              >Fail</div>
              <!-- <input type="checkbox" name="" id="" v-if="infoResult=='fail'"> <span>Notify Customer</span> -->
              <div
                class="notify-check"
                :class="{active: notifyCheck}"
                v-if="infoResult === 'fail'"
                @click="notifyCheck = !notifyCheck"
              ><img src="/img/check.png" alt="check" /></div>
              <span v-if="infoResult === 'fail'">Notify Customer</span>
            </div>
          </Card>

          <div class="button-group">
            <button @click="handleSubmit()">Submit</button>
            <button>Add More Traking</button>
          </div>
        </div>

      </div>

      <div class="spinner" v-if="uploading">
        <img src="/img/spinner.gif" alt="spinner" />
      </div>
    </div>
  </div>
</template>

<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGridPlugin from '@fullcalendar/timegrid';

import moment from 'moment'

export default {
  components: { FullCalendar },
  data() {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        eventSources: [],
        headerToolbar: {
          center: 'dayGridMonth,timeGridFourDay' // buttons for switching between views
        },
        views: {
          dayGridMonth: {
            buttonText: "Month"
          },
          timeGridFourDay: {
            type: 'timeGrid',
            duration: { days: 7 },
            buttonText: 'Week',
          }
        },
        eventClick: this.handleEventClick
      },
      eventSources: [],
      resolution: '',
      commets: '',
      selectedData: {selected: false},
      uploading: false,
      selectedFiles: [],
      infoResult: 'pass',
      notifyCheck: true
    }
  },

  methods: {
    fetchData() {
      let colors = ['red', 'blue', 'green', 'yellow', 'purple', 'pink', 'sky', 'orange', 'gold', 'silver']

      Nova.request()
        .get('/nova-vendor/calendar/calendar')
        .then((res) => {
          for(let i = 0; i < res.data.length; i ++) {
            let srcId;
            for(srcId = 0; srcId < this.eventSources.length; srcId ++) {
              if(this.eventSources[srcId].name === res.data[i].type) {
                break;
              }
            }
            if(srcId === this.eventSources.length) {
              this.eventSources.push({
                id: srcId,
                color: colors[srcId % 10],
                name: res.data[i].type,
                enable: true,
                events: []
              })
            }

            this.eventSources[srcId].events.push({
              id: i,
              title: `${res.data[i].docName}(${res.data[i].subType})`,
              date: res.data[i].trackingDate,
              allDay: false,
              dataId: i,
              data: {...res.data[i]}
            })
          }
          this.calendarOptions.eventSources = this.eventSources
        });
    },

    handleFilterButtonClick(index) {
      this.eventSources[index].enable = !(this.eventSources[index].enable)
      let tmp = []
      this.eventSources.forEach(item => {
        if(item.enable) {
          tmp.push(item)
        }
      })
      this.calendarOptions.eventSources = tmp
    },

    handleEventClick(e) {
      this.selectedData = {selected: true, ...(e.el.fcSeg.eventRange.def.extendedProps.data)}
      this.comments = ''
      this.resolution = ''
      this.infoResult = 'pass'
      if(this.$refs.file && this.$refs.file.files.length > 0)
        this.$refs.file.value = null
    },

    handleUploadFileClick() {
      this.$refs.file.value = null
      this.$refs.file.click()
    },

    handleSelectedFilesChange() {
      this.selectedFiles = []
      for(let i = 0; i < this.$refs.file.files.length; i ++) {
        this.selectedFiles.push(this.$refs.file.files[i])
      }
    },

    handleRemoveSelectedFile(index) {
      let tmp = []
      
      this.selectedFiles.forEach((file, i) => {
        if(i !== index) {
          tmp.push(file)
        }
      })
      this.selectedFiles = tmp;
    },

    handleSubmit() {
      let formData = new FormData()
      formData.append('resolutionStatus', this.infoResult)
      formData.append('status', this.selectedData.status)
      formData.append('resolution', this.resolution)
      formData.append('comments', this.comments)
      formData.append('instanceId', this.selectedData.id)
      formData.append('covenantId', this.selectedData.covenantId)

      for (let i = 0; i < this.selectedFiles.length; i++) {
        formData.append('files[]', this.selectedFiles[i])
      }

      this.uploading = true

      Nova.request().post('/nova-vendor/calendar/submitresult', formData).then((res) => {
        this.uploading = false
        window.alert(res.data.result)
      })
    }
  },

  created: function () {
    this.fetchData()
  }
}
</script>

<style>
.card-container {
  padding: 14px;
}


@import '@fullcalendar/common/main.css';
@import '@fullcalendar/daygrid/main.css';
@import '@fullcalendar/timegrid/main.css';
</style>
