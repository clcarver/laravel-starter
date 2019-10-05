<template>
    <div class="container mt-2">
        <div class="columns">
            <div class="column">
                <FullCalendar
                    @eventClick="getDetails"
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
    import axios from 'axios'
    import registrationDetails from '../../components/modals/registrationDetails'

    export default {
        components: {
            FullCalendar,
            registrationDetails
        },

        data() {
            return {
                calendarPlugins: [dayGridPlugin],
                events: [],
                modalActive: false,
                clickedEvent: {}
            }
        },

        methods: {
            getSchedule() {
                axios.get('/api/schedule').then((response) => {
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
                console.log(e)
            }
        },

        mounted() {
            this.getSchedule()
        }
    }
</script>
