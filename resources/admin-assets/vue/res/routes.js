let routes = [
    {path: '/', redirect: 'home'},
    {path: '/home', component: require("../pages/Home.vue")},
    {
        path: '/news',
        children: [
            {path: '', alias: 'main', component: require("../pages/Newses.vue")},
            {path: 'create', component: require("../pages/CreateNews.vue")},
            {path: ':id(\\d+)/edit', component: require("../pages/EditNews.vue")}
        ],
        component: {
            template: "<router-view></router-view>"
        }
    },
    {
        path: '/faq',
        children: [
            {path: '', alias: 'main', component: { template: "<div class='content-wrapper'><h1>Under construction</h1></div>"}},
            {path: 'create', component: require("../pages/CreateOrder.vue")},
            {path: ':id(\\d+)/edit', component: { template: "<h1>Under construction</h1>"}}
        ],
        component: {
            template: "<router-view></router-view>"
        }
    },
    {
        path: '/order',
        children: [
            {path: '', alias: 'main', component: require("../pages/Orders.vue")},
            // {path: 'main'},
            {path: 'create', component: require("../pages/CreateOrder.vue")},
            {path: ':id(\\d+)/edit', component: require("../pages/EditOrder.vue")}
        ],
        component: {
            template: "<router-view></router-view>"
        }
    },
    {
        path: '/user',
        children: [
            {path: '', alias: 'main', component: require("../pages/Users.vue")}
            // {path: 'main'},
        ],
        component: {
            template: "<router-view></router-view>"
        }
    },
    {
        path: '/shops',
        children: [
            {path: '', alias: 'main', component: require("../pages/Shops.vue")},
            // {path: 'main'},
            // {path: 'create', component: require("../pages/CreateOrder.vue")},
            // {path: ':id(\\d+)/edit', component: require("../pages/EditOrder.vue")}
        ],
        component: {
            template: "<router-view></router-view>"
        }
    },
    {path: '/options', component: require("../pages/Options.vue")}
];
export default routes;