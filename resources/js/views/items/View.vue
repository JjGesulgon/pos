<template>
    <div>
        <div class="card">
            <div class="card-header">
                <router-link class="text-primary" :to="{ name: 'item-types.index' }">Items</router-link>
                /
                <span class="text-secondary">View Item</span>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <fieldset disabled>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="item.name" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="name">Stock Keeping Unit</label>
                                <input type="text" class="form-control" v-model="item.stock_keeping_unit" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Identifier</label>
                                <input class="form-control" v-model="item.identifier" readonly></input>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" v-model="item.description" readonly></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label>Item Type</label>
                                <input type="text" class="form-control" v-model="item.item_type.name" readonly>
                            </div>
                            <div class="col-md-3 form-group">
                                <label> Item Classification</label>
                                <input type="text" class="form-control" v-model="item.item_classification.name" readonly>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Unit of Measurement</label>
                                <input type="text" class="form-control" v-model="item.default_unit_of_measurement.name" readonly>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Unit of Measurement</label>
                                <input type="text" class="form-control" v-model="item.brand.name" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Purchase Discounts</label>
                                <span v-for="(purchase_discount, index) in item.purchase_discounts" :key="index">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">%</div>
                                        </div>
                                        <input type="text" class="form-control" v-model="purchase_discount.discount" readonly>
                                    </div>
                                    <br>
                                </span>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Sales Discounts</label>
                                <span v-for="(sales_discount, index) in item.sales_discounts" :key="index">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">%</div>
                                        </div>
                                        <input type="text" class="form-control" v-model="sales_discount.discount" readonly>
                                    </div>
                                    <br>
                                </span>
                            </div>
                        </div>
                    </fieldset>

                    <br>

                    <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'items.index' }"><i class="fas fa-chevron-left"></i>&nbsp; Back</router-link>
                    <router-link class="btn btn-primary btn-sm" :to="{ name: 'items.edit' , params: { id: item.id }}"><i class="fas fa-edit"></i>&nbsp; Edit Item</router-link>
                    <button type="button" class="btn btn-danger btn-sm" @click.prevent="openDeleteItemModal()"><i class="fas fa-trash-alt"></i>&nbsp; Delete Item</button>
                </div>
                <div v-else>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="deleteItemTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">You're about to delete this Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete <b><u>{{item.name}}</u></b> ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="deleteItem()">Confirm Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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
                accountType: "",
                item: '',
                itemType: '',
                itemClass: '',
                item_type_id: '',
                item_classification_id: ''
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get("/api/items/" + this.$route.params.id).then(res => {
                    this.item = res.data.item;
                    resolve();
                }).catch(err => {
                    reject();
                    console.log(err);
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            openDeleteItemModal() {
                $('#deleteItemModal').modal('show');
            },
            deleteItem() {
                axios.delete('/api/items/' + this.$route.params.id).then(res => {
                    $('#deleteItemModal').modal('hide');
                    this.$router.push({ name: 'items.index' });
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    };
</script>
