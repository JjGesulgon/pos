<template>
    <div>
        <div class="card">
            <div class="card-header">
                <router-link class="text-primary" :to="{ name: 'items.index' }">Item</router-link>
                /
                <span class="text-secondary">Edit Item</span>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <form v-on:submit.prevent="updateUser()">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" v-model="name" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="amount">Price</label>
                                    <input type="number" class="form-control" v-model="amount" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="amount">Stocks Available</label>
                                    <input type="number" class="form-control" v-model="stocks_available" autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <br>

                        <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'items.index' }"><i class="fas fa-chevron-left"></i>&nbsp; Back</router-link>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-edit"></i>&nbsp; Update Item</button>
                    </form>
                </div>
                <div v-else>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady: false,
                name: '',
                amount: '',
                stocks_available: ''
            };
        },

        mounted() {
            let retrieveUserPromise = new Promise((resolve, reject) => {
                axios.get('/api/items/' + this.$route.params.id).then(res => {
                    this.id                 = res.data.item.id;
                    this.name               = res.data.item.name;
                    this.amount             = res.data.item.amount;
                    this.stocks_available   = res.data.item.stocks_available;

                    resolve();
                });
            });

            Promise.all([retrieveUserPromise]).then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            updateUser() {
                this.ifReady = false;

                let data = {
                    name: this.name,
                    amount: this.amount,
                    stocks_available: this.stocks_available
                };

                axios.patch('/api/items/' + this.$route.params.id, data).then(res => {
                    Broadcast.$emit('ToastMessage', {
                        message: 'Item Updated Successfully'
                    });

                    this.$router.push({
                        name: 'items.index',
                    });
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>
