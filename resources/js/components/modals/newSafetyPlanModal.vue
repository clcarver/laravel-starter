<template>
    <form action="">
        <div class="modal-card show-overflow">
            <header class="modal-card-head flex-column">
                <p class="modal-card-title">Add New Plan</p>
                <p class="subtitle is-6 mb-0 mt-1">Ensure new data has been uploaded if you can't find what you are looking for!</p>
            </header>
            <section class="modal-card-body show-overflow">
                <b-field label="Find a course">
                    <b-autocomplete
                        @select="getRelations"
                        :data="data"
                        placeholder="MALT-1234"
                        field="activity_code"
                        :loading="isFetching"
                        @typing="getAsyncData">

                        <template slot-scope="props">
                            <div class="media">
                                <div class="media-content">
                                    {{ props.option.activity_code }}
                                    <br>
                                    <small>
                                        {{ props.option.activity_name }},
                                    </small>
                                </div>
                            </div>
                        </template>
                    </b-autocomplete>
                </b-field>

                <b-field :label="selectedTitle">
                    <ul>
                        <li v-for="course in directChildren">
                            {{ course.reference.activity_code }} - {{ course.reference.activity_name }}
                        </li>
                    </ul>
                </b-field>
            </section>
            <footer class="modal-card-foot">
                <button @click="$parent.close()" class="button" type="button" >Close</button>
            </footer>
        </div>
    </form>
</template>

<script>
    import debounce from 'lodash/debounce'
    import axios from 'axios'
    export default {
        data() {
            return {
                isFetching: false,
                data: [],
                selected: [],
                directChildren: []
            }
        },

        computed: {
            selectedTitle() {
                return this.selected.activity_name
            }
        },

        methods: {
            getAsyncData: debounce(function (name) {
                if (!name.length) {
                    this.data = []
                    return
                }
                this.isFetching = true
                axios.get(`/api/lms/search?q=${name}`)
                    .then(({ data }) => {
                        this.data = []
                        data.forEach((item) => this.data.push(item))
                    })
                    .catch((error) => {
                        this.data = []
                        throw error
                    })
                    .finally(() => {
                        this.isFetching = false
                    })
            }, 500),

            getRelations(option) {
                if(option !== null)
                    this.selected = option
                else
                    this.selected = []
                if(option !== null)
                    this.searchRelations(option.id)
            },

            searchRelations(id) {
                axios.get('/api/lms/course/' + id).then((response) => {
                    this.directChildren = response.data
                })
            }
        }
    }
</script>
