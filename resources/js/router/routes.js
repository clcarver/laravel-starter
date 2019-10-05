function page(path) {
    return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
    {path: '/', name: 'welcome', component: page('welcome.vue')},

    {path: '/login', name: 'login', component: page('auth/login.vue')},
    {path: '/register', name: 'register', component: page('auth/register.vue')},
    {path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue')},
    {path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue')},
    {path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue')},
    {path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue')},

    {path: '/schedule', name: 'schedule', component: page('schedule/index.vue')},
    {path: '/uploads', name: 'uploads', component: page('uploads/index.vue')},
    {
        path: '/settings',
        component: page('settings/index.vue'),
        children: [
            {path: '', redirect: {name: 'settings.profile'}},
            {path: 'profile', name: 'settings.profile', component: page('settings/profile.vue')},
            {path: 'password', name: 'settings.password', component: page('settings/password.vue')}
        ]
    },

    {
        path: '/safety',
        component: page('safety/index.vue'),
        children: [
            {path: '', redirect: {name: 'safety.dashboard'}},
            {path: 'dashboard', name: 'safety.dashboard', component: page('safety/dashboard.vue')},
            {path: ':wc', name: 'safety.group', component: page('safety/group.vue')},
        ]
    },

    {path: '*', component: page('errors/404.vue')}
]
