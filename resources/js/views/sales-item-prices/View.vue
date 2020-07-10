<template>
    <div>
        <div v-if="ifReady">
            <div class="card">
                <div class="card-header">
                    <a class="text-primary" href="#" @click.prevent="viewSalesItemPrices()">Sales Item Prices</a>
                    <span class="text-secondary"> / View Sales Item Price</span>
                </div>
                <div class="card-body">
                    <fieldset disabled>
                        <div class="form-group">
                            <label for="name">Item</label>
                            <input type="text" class="form-control" v-model="salesItemPrice.item.name" autocomplete="off" minlength="2" maxlength="255" required>
                        </div>

                        <div class="form-group">
                            <label for="name">Price</label>
                            <input type="text" class="form-control" v-model="salesItemPrice.price" autocomplete="off" minlength="2" maxlength="255" required>
                        </div>
                    </fieldset>

                    <br>

                    <button type="button" class="btn btn-outline-secondary btn-sm" @click.prevent.default="viewSalesItemPrices()"><i class="fas fa-chevron-left"></i>&nbsp; Back</button>
                    <button type="button" class="btn btn-primary btn-sm" @click.prevent.default="editSalesItemPrice()"><i class="fas fa-edit"></i>&nbsp; Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="openDeleteSalesItemPriceModal()"><i class="fas fa-trash-alt"></i>&nbsp; Delete</button>
                </div>
            </div>
            
            <div class="modal fade" id="deleteSaleItemPriceModal" tabindex="-1" role="dialog" aria-labelledby="deleteSaleItemPriceTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">You're about to delete this Sales Item Price?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this Item <b><u>{{ salesItemPrice.item.name }} - {{ salesItemPrice.price }} </u></b>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="deleteItemPricelists()">Confirm Delete</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
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
                salesItemPrice: ''
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/sales-item-prices/' + this.$route.params.id).then(res => {
                    this.salesItemPrice = res.data.sales_item_price;
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
            editSalesItemPrice() {
                this.$router.push({
                    name: 'sales-item-prices.edit',
                    params: { id: this.salesItemPrice.id }
                });
            },
            openDeleteSalesItemPriceModal() {
                $('#deleteSaleItemPriceModal').modal('show');
            },
            deleteItemPricelists() {
                axios.delete('/api/sales-item-prices/' + this.$route.params.id).then(res => {
                    this.$router.push({ name: 'sales-item-prices.index' });
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>
