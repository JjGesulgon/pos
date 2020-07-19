<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container-fluid">
            <router-link class="navbar-brand" :to="{ name: 'overview' }">Point of Sale</router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
                    <li v-if="corporation">
                        <a class="nav-link" href="#" v-on:click.stop.prevent="">{{ corporation.name }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ user.name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <router-link class="dropdown-item" :to="{ name: 'corporations.select' }">Select Corporation</router-link>
                            <a class="dropdown-item" href="#" v-on:click.stop.prevent="logout">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                corporation: '',
                user: ''
            };
        },

        mounted() {
            /*Broadcast.$on('System Initialized', (event) => {
                this.user = this.$store.state.user;
            });*/

            axios.get('/api/auth/user').then(res => {
                this.user = res.data.user;
                localStorage.setItem('user', JSON.stringify(res.data.user));
            });

            if (JSON.parse(localStorage.getItem('selectedCorporation')) instanceof Object == false) {
                this.$router.push({ name: 'corporations.select' });
            } else {
                this.$store.state.selectedCorporation = JSON.parse(localStorage.getItem('selectedCorporation'));
                this.corporation = JSON.parse(localStorage.getItem('selectedCorporation'));
                axios.defaults.headers.common['CORPORATION-ID'] = JSON.parse(localStorage.getItem('selectedCorporation')).id;
            }

            Broadcast.$on('ChangeCorporation', (event) => {
                this.corporation = event.corporation;
            });
        },
        methods: {
            logout() {
                axios.post('/logout').then(res => {
                    localStorage.clear();
                    location.reload();
                }).catch(function (error) {
                    localStorage.clear();
                    location.reload();
                });
            }
        }
    }
</script>
