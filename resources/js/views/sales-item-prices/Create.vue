<template>
    <div>
        <div v-if="ifReady">
            <div class="card">
                <div class="card-header">
                    <a class="text-primary" href="#" @click.prevent="viewSalesItemPrices()">Sales Item Prices</a>
                    <span class="text-secondary"> / Create New Sales Item Price</span>
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="createNewSalesItemPriceList">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="item">Item</label>
                                    <vue-select id="item" class="form-control" v-model="item" @input="selectItem()" label="name" :options="items"></vue-select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input id="price" type="number" class="form-control" v-model="price" autocomplete="off" minlength="1" maxlength="255" placeholder="0.00" required>
                                </div>
                            </div>
                        </div>

                        <br>

                        <button type="button" class="btn btn-outline-secondary btn-sm" @click.prevent="viewSalesItemPrices()"><i class="fas fa-chevron-left"></i>&nbsp; Back</button>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-plus"></i>&nbsp; Create New Sales Item Price</button>
                    </form>

                </div>
            </div>
        </div>

        <div v-else>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady: false,
                items: [],
                item: null,
                item_id: '',
                price: ''
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/items/get-all-items/').then(res => {
                    this.items = res.data.items;
                    resolve();
                }).catch(err => {
                    console.log(err);
                    reject();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            viewSalesItemPrices() {
                this.$router.push({ name: 'sales-item-prices.index' });
            },
            selectItem() {
                this.item_id = this.item.id;
            },
            createNewSalesItemPriceList() {
                this.ifReady = false;

                axios.post('/api/sales-item-prices', this.$data).then(res => {
                    this.$router.push({ name: 'sales-item-prices.index' });
                }).catch(err => {
                    this.ifReady = true;
                    console.log(err);
                });
            }
        }
    }
</script>
