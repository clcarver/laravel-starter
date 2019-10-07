<template>
    <form action="">
        <div class="modal-card">
            <header class="modal-card-head flex-column">
                <p class="modal-card-title" v-text="event.title"></p>
                <p class="subtitle is-6 mb-0 mt-1">{{ event.id }}</p>
                <p class="subtitle is-6">{{ location }}</p>
            </header>
            <section class="modal-card-body">
                <div v-if="isLoading">
                    <img src="/images/skeleton.gif" alt="loading...">
                </div>
                <b-table :data="data" :loading="isLoading">
                    <template slot-scope="props">
                        <b-table-column field="first_name" label="First Name">
                            {{ props.row.first_name }}
                        </b-table-column>

                        <b-table-column field="last_name" label="Last Name">
                            {{ props.row.last_name }}
                        </b-table-column>

                        <b-table-column field="user.shift" label="Shift">
                            {{ props.row.user.shift }}
                        </b-table-column>

                        <b-table-column field="registration_date" label="Registered On">
                            {{ props.row.registration_date }}
                        </b-table-column>
                    </template>
                </b-table>
            </section>
            <footer class="modal-card-foot">
                <button @click="$parent.close()" class="button" type="button" >Close</button>
            </footer>
        </div>
    </form>
</template>

<script>
    import axios from 'axios'
    import collect from 'collect.js'

    export default {
        props: [
            'event'
        ],

        data() {
            return {
                data: [],
                isLoading: true
            }
        },

        computed: {
            location() {
                return collect(this.data).pluck('location').first()
            }
        },

        methods: {
            getClassRoster() {
                this.isLoading = true
                axios.get('./api/lms/registration/' + this.event.id).then(({data}) => {
                    this.data = data
                }).finally(() => {
                    this.isLoading = false
                })
            }
        },

        mounted() {
            this.getClassRoster()
        }
    }
</script>
