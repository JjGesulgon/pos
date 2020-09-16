<template>
    <div class="card">
        <div class="card-header">
            <router-link class="text-primary" :to="{ name: 'receive-orders.index' }">Stocks</router-link>
            /
            <span class="text-secondary">View Stock</span>
        </div>
        <div class="card-body">
            <div v-if="ifReady">
                <fieldset disabled>
                    <div class="form-group">
                        <label for="name">Stock From</label>
                        <input type="text" class="form-control" v-model="stockable.name" autocomplete="off" minlength="2" maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="adress">Item Name</label>
                        <input type="text" class="form-control" v-model="item.name" autocomplete="off" minlength="2" maxlength="255" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="city">Quantity</label>
                            <input type="text" class="form-control" v-model="stocks.quantity" autocomplete="off" minlength="2" maxlength="255" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="country">UOM</label>
                            <input type="text" class="form-control" v-model="uom.name" autocomplete="off" minlength="2" maxlength="255" required>
                        </div>
                    </div>
                </fieldset>

                <button type="button" class="btn btn-outline-success btn-sm" @click.prevent.default="viewStocks"><i class="fas fa-chevron-left"></i> Back</button>
            </div>
            <div v-else>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
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
                stocks: [],
                stockable: [],
                uom: [],
                item: [],             
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/stocks/' + this.$route.params.id).then(res => {
                    this.stocks = res.data.stock;
                    this.stockable = res.data.stock.stockable;
                    this.uom = res.data.stock.unit_of_measurement;
                    this.item = res.data.stock.item;
                    resolve();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            viewStocks() {
                this.$router.push({
                    name: 'stocks.index'
                });
            }
        }
    }
</script>
