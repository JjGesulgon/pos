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
                    <router-link class="nav-link" :to="{ name: 'overview' }">Items</router-link>
                </li>

                <li class="nav-item">
                    <router-link class="nav-link" :to="{ name: 'overview' }">Transactions</router-link>
                </li>
            </ul>
        </div>

        <div class="sticky-top">
            <ul class="nav flex-column background py-1 mt-3 sidebar-nav">
                <li class="nav-item">
                    <span class="nav-link"><i class="fas fa-user"></i>&nbsp; Manage Users</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#users" data-toggle="collapse" aria-expanded="false" aria-controls="users">
                        Users <i class="float-right fas fa-caret-down"></i>
                    </a>
                </li>
                <div class="collapse" id="users">
                    <ul class="nav flex-column nav-sub-menu">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'users.create' }">Create New User</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'users.index' }">View Users</router-link>
                        </li>
                    </ul>
                </div>
                
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

        }
    }
</script>
