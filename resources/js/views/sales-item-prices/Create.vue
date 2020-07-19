<template>
    <div>
        <div v-if="ifReady">
            <div class="card">
                <div class="card-header">
                    <router-link class="text-primary" :to="{ name: 'sales-item-prices.index' }">Sales Item Prices</router-link>
                    /
                    <span class="text-secondary">Create New Sales Item Price</span>
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="createNewSalesItemPriceList()">
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
                            <div class="col-md-6">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is-default" v-model="is_default">
                                    <label class="form-check-label" for="is-default"><strong>Make Default Sales Item Price</strong></label>
                                </div>
                            </div>
                        </div>

                        <br>

                        <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'sales-item-prices.index' }"><i class="fas fa-chevron-left"></i> &nbsp;Back</router-link>
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
                price: '',
                is_default: false
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/items/get-all-items').then(res => {
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
            selectItem() {
                this.item_id = this.item.id;
            },
            createNewSalesItemPriceList() {
                this.ifReady = false;

                let formData = {
                    item_id: this.item_id,
                    price: this.price,
                    is_default: this.is_default
                };

                axios.post('/api/sales-item-prices', formData).then(res => {
                    this.$router.push({ name: 'sales-item-prices.index' });
                }).catch(err => {
                    this.ifReady = true;
                    console.log(err);
                });
            }
        }
    }
</script>
