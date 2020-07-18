import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const Overview = () => import('./views/Overview');

/**
 * Contacts
 * 
 */
const ContactsIndex = () => import('./views/contacts/Index');
const ContactsCreate = () => import('./views/contacts/Create');
const ContactsEdit = () => import('./views/contacts/Edit');
const ContactsView = () => import('./views/contacts/View');

/**
 * Corporations
 * 
 */
const CorporationsIndex = () => import('./views/corporations/Index');
const CorporationsCreate = () => import('./views/corporations/Create');
const CorporationsView = () => import('./views/corporations/View');
const CorporationsEdit = () => import('./views/corporations/Edit');
const CorporationsSelect = () => import('./views/corporations/Select');

/**
 * Items
 *
 */
const ItemsIndex = () => import('./views/items/Index');
const ItemsCreate = () => import('./views/items/Create');
const ItemsView = () => import('./views/items/View');
const ItemsEdit = () => import('./views/items/Edit');

/**
 * Sales Item Prices
 *
 */
const SalesItemPricesIndex = () => import('./views/sales-item-prices/Index');
const SalesItemPricesCreate = () => import('./views/sales-item-prices/Create');
const SalesItemPricesView = () => import('./views/sales-item-prices/View');
const SalesItemPricesEdit = () => import('./views/sales-item-prices/Edit');

/**
 * Stocks
 * 
 */
const StocksIndex = () => import('./views/stocks/Index');
const StocksView = () => import('./views/stocks/View');

/**
 * Transactions
 * 
 */
const TransactionsCreate  = () => import('./views/transactions/Create');
const TransactionsIndex  = () => import('./views/transactions/Index');

/**
 * Users
 * 
 */
const UsersIndex  = () => import('./views/users/Index');
const UsersCreate = () => import('./views/users/Create');
const UsersView   = () => import('./views/users/View');
const UsersEdit   = () => import('./views/users/Edit');

export default new Router({
    mode: 'history',
    routes: [
        // Overiew
        { path: '/', name: 'overview', component: Overview },

        // Contacts
        { path: '/contacts', name: 'contacts.index', component: ContactsIndex },
        { path: '/contacts/create', name: 'contacts.create', component: ContactsCreate },
        { path: '/contacts/:id', name: 'contacts.view', component: ContactsView },
        { path: '/contacts/:id/edit', name: 'contacts.edit', component: ContactsEdit },

        // Corporations
        { path: 'corporations/select', name: 'corporations.select', component: CorporationsSelect },
        { path: 'corporations', name: 'corporations.index', component: CorporationsIndex },
        { path: 'corporations/create', name: 'corporations.create', component: CorporationsCreate },
        { path: 'corporations/:id', name: 'corporations.view', component: CorporationsView },
        { path: 'corporations/:id/edit', name: 'corporations.edit', component: CorporationsEdit },

        // Items
        { path: '/items', name: 'items.index', component: ItemsIndex },
        { path: '/items/create', name: 'items.create', component: ItemsCreate },
        { path: '/items/:id', name: 'items.view', component: ItemsView },
        { path: '/items/:id/edit', name: 'items.edit', component: ItemsEdit },

        // Sales Item Prices
        { path: '/sales-item-prices', name: 'sales-item-prices.index', component: SalesItemPricesIndex },
        { path: '/sales-item-prices/create', name: 'sales-item-prices.create', component: SalesItemPricesCreate },
        { path: '/sales-item-prices/:id', name: 'sales-item-prices.view', component: SalesItemPricesView },
        { path: '/sales-item-prices/:id/edit', name: 'sales-item-prices.edit', component: SalesItemPricesEdit },

        // Stocks
        { path: '/stocks', name: 'stocks.index', component: StocksIndex },
        { path: '/stocks/:id', name: 'stocks.view', component: StocksView },

        // Transactions
        { path: '/transactions', name: 'transactions.index', component: TransactionsIndex },
        { path: '/transactions/create', name: 'transactions.create', component: TransactionsCreate },

        // Users
        { path: '/users', name: 'users.index', component: UsersIndex },
        { path: '/users/create', name: 'users.create', component: UsersCreate },
        { path: '/users/:id', name: 'users.view', component: UsersView },
        { path: '/users/:id/edit', name: 'users.edit', component: UsersEdit }
    ]
});
