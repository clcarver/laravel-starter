<template>
    <div class="container mt-5">

        <nav class="level is-mobile">
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Expired Certifications</p>
                    <div class="d-flex items-center justify-center">
                        <b-icon
                            class="mr-2"
                            icon="alert-octagram"
                            size="is-medium"
                            type="is-danger">
                        </b-icon>
                    <p class="title">150</p>
                    </div>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Training Today</p>
                    <p class="title">0</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">Safety Plans</p>
                    <div class="d-flex items-center justify-center">
                        <b-icon
                            class="mr-2 text-orange"
                            icon="hard-hat"
                            size="is-medium">
                        </b-icon>
                        <p class="title">15</p>
                    </div>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">No Shows</p>
                    <p class="title">2</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <p class="heading">No Status</p>
                    <p class="title">15</p>
                </div>
            </div>
        </nav>

        <div class="columns is-multiline is-mobile">
            <div class="column is-one-quarter" v-for="(org, name) in structure.items">
                <div class="card">
                    <header class="card-header items-center">
                        <p class="card-header-title">
                            {{ name }}
                        </p>
                        <b-icon class="pr-3" icon="tools"></b-icon>
                    </header>

                    <div class="card-content">
                        <div class="d-flex items-center justify-between" v-for="position in org.items">
                            <p>{{ position.position }}</p>
                            <p>{{ position.count }}</p>
                        </div>
                        <hr>
                        <div class="d-flex items-center justify-between">
                            <p>Total</p>
                            <p>{{ getSum(org.items) }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    import axios from 'axios'
    import collect from 'collect.js'

    export default {
        data() {
            return {
                data: [],
                structure: []
            }
        },

        methods: {
            getGroup(name) {
                return collect(this.data).where('organization', name)
            },

            getSum(items) {
                return collect(items).sum('count')
            }
        },

        computed: {

        },

        mounted() {
            axios.get('/api/lms/users').then(({data}) => {
                this.data = data

                this.structure = collect(data).filter((v) => {
                    return v.organization
                }).groupBy('organization')
            })
        }
    }

</script>
