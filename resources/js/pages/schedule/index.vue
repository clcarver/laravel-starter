<template>
    <div class="container mt-2">
        <div class="columns">
            <div class="column">
                <FullCalendar
                    @eventClick="getDetails"
                    :header="{
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                      }"
                    :datesRender="v => onDatesRender(v)"
                    defaultView="dayGridMonth" :events="events" :plugins="calendarPlugins"/>
            </div>
        </div>


        <b-modal :active.sync="modalActive" has-modal-card scroll="keep">
            <registration-details :event="clickedEvent"/>
        </b-modal>

    </div>
</template>

<script>
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import timeGridPlugin from "@fullcalendar/timegrid";
    import interactionPlugin from "@fullcalendar/interaction";
    import axios from 'axios'
    import registrationDetails from '../../components/modals/registrationDetails'
    import moment from 'moment'


    export default {
        components: {
            FullCalendar,
            registrationDetails
        },

        data() {
            return {
                calendarPlugins: [
                    dayGridPlugin,
                    timeGridPlugin,
                    interactionPlugin
                ],
                events: [],
                modalActive: false,
                clickedEvent: {},
                start: moment().subtract(1, 'month').startOf('day'),
                end: moment().add(1, 'month').endOf('day')
            }
        },

        methods: {
            getSchedule() {
                axios.get('/api/schedule?from=' + this.start.format('YYYY-MM-DD HH:mm:ss')
                    + '&to=' +this.end.format('YYYY-MM-DD HH:mm:ss')
                ).then((response) => {
                    this.events = response.data
                })
            },

            getDetails(e) {
                this.modalActive = true
                this.clickedEvent = {
                    id: e.event.id,
                    start: e.event.start,
                    end: e.event.end,
                    title: e.event.title
                }
            },

            onDatesRender(v) {
                console.log(moment(v.view.currentStart).month(), this.start.month(), this.end.month())
                if(
                    moment(v.view.currentStart).month() === this.start.month()
                    || moment(v.view.currentStart).month() === this.end.month()
                ) {
                    this.start = moment(v.view.currentStart).subtract(2, 'month').startOf('day')
                    this.end = moment(v.view.currentStart).add(2, 'month').endOf('day')
                    this.getSchedule()
                    console.log('fetch')
                }
            }
        },

        mounted() {
            this.getSchedule()
        }
    }
</script>
