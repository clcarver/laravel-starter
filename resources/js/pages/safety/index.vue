<template>
    <div>
        <section class="hero is-light">
            <div class="hero-body">
                <div class="container">
                    <div class="d-flex justify-between">
                        <h1 class="title mb-0">
                            Safety Plans
                        </h1>

                        <b-button @click="modalActive = !modalActive" type="is-primary">New</b-button>
                    </div>

                    <h2 class="subtitle">
                        Safety first!
                    </h2>
                </div>
            </div>

            <div class="hero-foot">
                <nav class="tabs is-boxed is-fullwidth">
                    <div class="container">
                        <ul>

                            <router-link tag="li" to="dashboard"><a>Dashboard</a></router-link>


                            <router-link tag="li" to="mechanical"><a>Mechanical</a></router-link>


                            <router-link tag="li" to="electrical"><a>Electrical</a></router-link>


                            <router-link tag="li" to="water"><a>UPW / WWT</a></router-link>

                            <li>
                                <a>Components</a>
                            </li>
                            <li>
                                <a>Layout</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </section>

        <div class="container">
            <div class="columns">
                <div class="column">
                    <transition name="fade" mode="out-in">
                        <router-view :key="$route.path"/>
                    </transition>
                </div>
            </div>
        </div>

        <b-modal :active.sync="modalActive" has-modal-card scroll="keep">
            <new-safety-plan-modal/>
        </b-modal>
    </div>
</template>

<script>
    import newSafetyPlanModal from "../../components/modals/newSafetyPlanModal";
    export default {
        components: {
            newSafetyPlanModal
        },

        data() {
            return {
                modalActive: false
            }
        }
    }
</script>
