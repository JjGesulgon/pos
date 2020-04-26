<template>
    <div>
        <div class="card">
            <div class="card-header">
                <router-link class="text-primary" :to="{ name: 'items.index' }">Items</router-link>
                /
                <span class="text-secondary">Create New Item</span>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <form v-on:submit.prevent="createNewItem()">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" v-model="name" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="amount">Price</label>
                                    <input type="number" class="form-control" v-model="amount" autocomplete="off" step=".01" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="stocks_available">Stocks Available</label>
                                    <input type="number" class="form-control" v-model="stocks_available" autocomplete="off" required>
                                </div>
                            </div>
                        </div>

                        <br>
                        
                        <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'users.index' }"><i class="fas fa-chevron-left"></i> &nbsp;Back</router-link>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> &nbsp;Create New Item</button>
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
                ifReady: true,
                name: '',
                amount: '',
                stocks_available: '',
            };
        },
        methods: {
            createNewItem() {
                this.ifReady = false;

                axios.post('/api/items', this.$data).then(res => {
                    Broadcast.$emit('ToastMessage', {
                        message: 'Item Created Successfully'
                    });

                    this.$router.push({ name: 'items.index' });
                }).catch(err => {
                    this.ifReady = true;
                    console.log(err);
                });
            }
        }
    }
</script>
