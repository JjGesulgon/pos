<template>
    <div>
        <div class="sticky-top">
            <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'overview' }"><i class="fas fa-home"></i>&nbsp; Overview</router-link>
                </li>
            </ul>
        </div>

        <div class="sticky-top">
            <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
                <li class="nav-item">
                    <span class="nav-link"><i class="fas fa-briefcase"></i>&nbsp; Business Functions</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contacts" data-toggle="collapse" aria-expanded="false" aria-controls="contacts">
                        Contacts <i class="float-right fas fa-caret-down"></i>
                    </a>
                </li>
                <div class="collapse" id="contacts">
                    <ul class="nav flex-column nav-sub-menu">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'contacts.create' }">Create New Contact</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'contacts.index' }">View Contacts</router-link>
                        </li>
                    </ul>
                </div>

                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'stocks.index' }">Stocks</router-link>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#items" data-toggle="collapse" aria-expanded="false" aria-controls="items">
                        Items <i class="float-right fas fa-caret-down"></i>
                    </a>
                </li>
                <div class="collapse" id="items">
                    <ul class="nav flex-column nav-sub-menu">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'items.create' }">Create New Item</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'items.index' }">View Items</router-link>
                        </li>
                    </ul>
                </div>

                <li class="nav-item">
                    <a class="nav-link" href="#sales-item-prices" data-toggle="collapse" aria-expanded="false" aria-controls="sales-item-prices">
                        Sales Item Prices <i class="float-right fas fa-caret-down"></i>
                    </a>
                </li>
                <div class="collapse" id="sales-item-prices">
                    <ul class="nav flex-column nav-sub-menu">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'sales-item-prices.create' }">Create New Sales Item Price</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'sales-item-prices.index' }">View Sales Item Prices</router-link>
                        </li>
                    </ul>
                </div>

                <li class="nav-item">
                    <a class="nav-link" href="#transactions" data-toggle="collapse" aria-expanded="false" aria-controls="transactions">
                        Transactions <i class="float-right fas fa-caret-down"></i>
                    </a>
                </li>
                <div class="collapse" id="transactions">
                    <ul class="nav flex-column nav-sub-menu">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'transactions.index' }">Manage Transactions</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'transaction_history.index' }">Transaction History</router-link>
                        </li>
                    </ul>
                </div>
            </ul>
        </div>

        <div class="sticky-top">
            <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
                <li class="nav-item">
                    <span class="nav-link"><i class="fas fa-user"></i>&nbsp; Manage Users</span>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'users.index' }">Users</router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {}
</script>
