<template>
    <div>
        <div v-if="ifReady">
            <div class="card">
                <div class="card-header">
                    <a class="text-primary" href="#" @click.prevent="viewSalesItemPrices()">Sales Item Prices</a>
                    <span class="text-secondary"> / Edit Sales Item Price</span>
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="editItemClassification">
                        <div class="form-group">
                            <label for="name">Item</label>
                            <input type="text" class="form-control" v-model="item.name" autocomplete="off" minlength="2" maxlength="255" required readonly>
                        </div>

                        <div class="form-group">
                            <label for="name">Price</label>
                            <input type="text" class="form-control" v-model="price" autocomplete="off" minlength="2" maxlength="255" required>
                        </div>

                        <br>

                        <button type="button" class="btn btn-outline-secondary btn-sm" @click.prevent.default="viewSalesItemPrices()"><i class="fas fa-chevron-left"></i>&nbsp; Back</button>
                        <button type="button" class="btn btn-success btn-sm" @click.prevent.default="updateSalesItemPrice()"><i class="fas fa-edit"></i>&nbsp; Update Sale Item Price</button>
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
                item: '',
                id: '',
                item_id: '',
                price: '',
                status: 1
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/sales-item-prices/' + this.$route.params.id).then(res => {
                    this.id = res.data.sales_item_price.id;
                    this.price = res.data.sales_item_price.price;
                    this.item_id = res.data.sales_item_price.item.id;
                    this.item = res.data.sales_item_price.item;
                    resolve();
                }).catch(err => {
                    console.log(err);
                    alert('Error');
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
            updateSalesItemPrice() {
                this.ifReady = false;

                axios.patch('/api/sales-item-prices/' + this.$route.params.id, this.$data).then(res => {
                    this.$router.push({
                        name: 'sales-item-prices.view',
                        params: { id: this.$route.params.id }
                    });
                }).catch(err => {
                    this.ifReady = true;
                    console.log(err);
                });
            }
        }
    }
</script>
