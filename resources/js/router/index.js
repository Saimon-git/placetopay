
import Dashboard from "../views/dashboard";
import Users from "../views/users";
import Profile from "../views/auth/profile";
import Orders from "../views/orders";
import CreateOrder from "../views/orders/create";
import ShowOrder from "../views/orders/order";



import VueRouter from "vue-router";


const routes = [
    {
        path: '/dashboard',
        component: Dashboard,
    },
    {
        path: '/profile',
        component: Profile
    },
    {
        path: '/users',
        component: Users,
    },
    {
        path: '/orders',
        component: Orders,
    },
    {
        path: '/orders/create',
        component: CreateOrder,
    },
    {
        path: '/orders/:id',
        component: ShowOrder,
    },
];

export default new VueRouter({
    mode: 'history',
    routes
});
