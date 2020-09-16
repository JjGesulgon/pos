<template>
    <div>
        <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

        <div class="card">
            <div class="card-body">
                <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>
                <br>
                <form-view :apiPath="apiPath" :routePrefixName="routePrefixName" :singularName="singularName" :object="item" :selectedProperty="selectedProperty" :toastMessage="toastMessage">
                    <template v-bind:item="item" v-bind:ifReady="ifReady">
                        <div v-if="ifReady" class="row">
                            <div class="col-md-3 form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" v-model="item.name" readonly>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="stock-keeping-unit">Stock Keeping Unit</label>
                                <input id="stock-keeping-unit" class="form-control" v-model="item.stock_keeping_unit" readonly>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="universal-product-code">Universal Product Code</label>
                                <input id="universal-product-code" class="form-control" v-model="item.universal_product_code" readonly>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="identifier">Identifier</label>
                                <input id="identifier" class="form-control" v-model="item.identifier" readonly>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control" v-model="item.description" readonly></textarea>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Brand</label>
                                <input type="text" class="form-control" v-model="item.brand.display_name" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Item Classification</label>
                                <input type="text" class="form-control" v-model="item.item_classification.display_name" readonly>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Item Type</label>
                                <input type="text" class="form-control" v-model="item.item_type.display_name" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Default Purchase Item Price</label>
                                <input v-if="item.default_purchase_item_price" type="text" class="form-control" v-model="item.default_purchase_item_price.price" readonly>
                                <input v-else type="text" class="form-control" value="" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Default Sales Item Price</label>
                                <input v-if="item.default_sales_item_price" type="text" class="form-control" v-model="item.default_sales_item_price.price" readonly>
                                <input v-else type="text" class="form-control" value="" readonly>
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
                    </template>
                </form-view>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady:          false,
                action:           'View',
                title:            'View Item',
                singularName:     'Item',
                pluralName:       'Items',
                apiPath:          '/api/items',
                routePrefixName:  'items',
                useName:          'singular',
                selectedProperty: 'name',
                toastMessage:     'Item',
                item:             {}
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get(this.apiPath + '/' + this.$route.params.id).then(res => {
                    this.item = res.data.item;
                    resolve();
                }).catch(err => {
                    reject();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        }
    }
</script>

