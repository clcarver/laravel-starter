<template>
    <div class="main-layout">
        <navbar/>

        <div class="columns is-fullheight is-gapless">
            <div class="column is-2 is-sidebar-menu is-hidden-mobile">
                <aside class="menu p-2">
                    <p class="menu-label">
                        General
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link class="d-flex items-center" to="/" exact>
                                <b-icon
                                    class="mr-2"
                                    icon="finance">
                                </b-icon>
                                <span>Dashboard</span>
                            </router-link>
                        </li>
                    </ul>
                    <p class="menu-label">
                        Maps
                    </p>
                    <ul class="menu-list">
                        <li><a class="d-flex items-center">
                            <b-icon
                                class="mr-2"
                                icon="map-search-outline">
                            </b-icon>
                            <span>Core Maps</span>
                        </a></li>
                        <li>
                            <router-link class="d-flex items-center" :class="{'is-active': subIsActive('/safety')}"
                                         to="/safety" exact>
                                <b-icon
                                    class="mr-2"
                                    icon="safety-goggles">
                                </b-icon>
                                <span>Safety Maps</span>
                            </router-link>
                        </li>
                        <li><a class="d-flex items-center">
                            <b-icon
                                class="mr-2"
                                icon="emoticon-kiss-outline">
                            </b-icon>
                            <span>Facilities NEO</span>
                        </a></li>
                        <li><a class="d-flex items-center">
                            <b-icon
                                class="mr-2"
                                icon="emoticon-poop">
                            </b-icon>
                            <span>GlobalFoundations</span>
                        </a></li>
                        <li><a class="d-flex items-center">
                            <b-icon
                                class="mr-2"
                                icon="auto-fix">
                            </b-icon>
                            <span>New Class Wizard</span>
                        </a></li>
                    </ul>
                    <p class="menu-label">
                        Administration
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link class="d-flex items-center" to="/schedule">
                                <b-icon
                                    class="mr-2"
                                    icon="calendar-month-outline">
                                </b-icon>
                                <span>Schedule</span>
                            </router-link>
                        </li>
                        <li>
                            <router-link class="d-flex items-center" to="/uploads">
                                <b-icon
                                    class="mr-2"
                                    icon="account">
                                </b-icon>
                                <span>Upload</span>
                            </router-link>
                        </li>
                    </ul>

                </aside>
            </div>
            <div class="column is-main-content">
                <transition name="fade" mode="out-in">
                    <child/>
                </transition>
            </div>
        </div>

        <portal-target name="model">

        </portal-target>
    </div>
</template>

<script>
    import Navbar from '~/components/Navbar'

    export default {
        name: 'MainLayout',

        components: {
            Navbar
        },

        methods: {
            subIsActive(input) {
                const paths = Array.isArray(input) ? input : [input]

                return paths.some(path => {
                    return this.$route.path.indexOf(path) === 0 // current path starts with this path string
                })
            }
        }
    }
</script>
