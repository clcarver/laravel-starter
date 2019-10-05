<template>
    <div class="section">
        <div class="container">
            <div class="columns is-multiline">
                <div class="column is-one-third">
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-content">
                                    <b-upload v-model="form.dropFiles"
                                              multiple
                                              class="is-block"
                                              drag-drop>
                                        <section class="section">
                                            <div class="content has-text-centered">
                                                <p>
                                                    <b-icon
                                                        icon="upload"
                                                        size="is-large">
                                                    </b-icon>
                                                </p>
                                                <p>Drop your files here or click to upload</p>
                                            </div>
                                        </section>
                                    </b-upload>
                                </div>
                            </div>
                        </div>
                        <footer class="card-footer">
                            <a @click.prevent="doUpload" class="card-footer-item">Upload</a>
                        </footer>
                    </div>
                </div>
                <div class="column">
                    <div class="tags">
                        <span v-for="(file, index) in form.dropFiles"
                              :key="index"
                              class="tag is-primary">
                            {{file.name}}
                            <button class="delete is-small"
                                    type="button"
                                    @click="deleteDropFile(index)">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import form from 'form-backend-validation'

    export default {
        layout: 'basic',

        data: () => ({
            title: window.config.appName,
            form: new form({
                dropFiles: []
            })
        }),

        methods: {
            deleteDropFile(index) {
                this.form.dropFiles.splice(index, 1)
            },

            doUpload() {
                this.form.post('./api/excel').then((response) => {
                    console.log(response.data)
                })
            }
        },

        computed: mapGetters({
            authenticated: 'auth/check'
        })
    }
</script>
