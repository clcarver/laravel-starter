<template>
    <div class="section">
        <div class="container">
            <div class="columns is-multiline">
                <div class="column is-one-third">
                    <div class="card card-hover">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img class="is-rounded" src="https://bulma.io/images/placeholders/96x96.png"
                                             alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <div class="d-flex justify-between items-center">
                                        <p class="title is-4 mb-1">Christopher Carver</p>
                                        <b-icon
                                            icon="account-check"
                                            type="is-success">

                                        </b-icon>
                                    </div>

                                    <p class="subtitle is-6">Jonathan Carlin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="card card-hover">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img class="is-rounded" src="https://bulma.io/images/placeholders/96x96.png"
                                             alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <div class="d-flex justify-between items-center">
                                        <p class="title is-4 mb-1">Venkata Dronamraju</p>
                                        <b-icon
                                            icon="account-alert"
                                            type="is-warning">

                                        </b-icon>
                                    </div>

                                    <p class="subtitle is-6">Jonathan Carlin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="card card-hover">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img class="is-rounded" src="https://bulma.io/images/placeholders/96x96.png"
                                             alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <div class="d-flex justify-between items-center">
                                        <p class="title is-4 mb-1">John Woodbeck</p>
                                        <b-icon
                                            icon="account-check"
                                            type="is-success">

                                        </b-icon>
                                    </div>

                                    <p class="subtitle is-6">Stephen Camino</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="column is-one-third">
                    <div class="card card-hover">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img class="is-rounded" src="https://bulma.io/images/placeholders/96x96.png"
                                             alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <div class="d-flex justify-between items-center">
                                        <p class="title is-4 mb-1">Andrew Gendron</p>
                                        <b-icon
                                            icon="alert-circle"
                                            type="is-danger">

                                        </b-icon>
                                    </div>

                                    <p class="subtitle is-6">Thomas Huang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        layout: 'basic',

        data: () => ({
            title: window.config.appName
        }),

        computed: mapGetters({
            authenticated: 'auth/check'
        })
    }

</script>
