<template>
    <div>
        <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

        <div class="card">
            <div class="card-body">
                <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>
                <br>
                <form-view :apiPath="apiPath" :routePrefixName="routePrefixName" :singularName="singularName" :object="salesItemPrice" :selectedProperty="selectedProperty" :toastMessage="toastMessage">
                    <template v-bind:salesItemPrice="salesItemPrice" v-bind:ifReady="ifReady">
                        <div v-if="ifReady" class="row">
                            <div class="col-md-3 form-group">
                                <label for="item">Item</label>
                                <input id="item" type="text" class="form-control" v-model="salesItemPrice.item.name_identifier" autocomplete="off" maxlength="255">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="measuring-mass">Measuring Mass</label>
                                <input id="measuring-mass" type="text" class="form-control" v-model="salesItemPrice.measuring_mass.mass" autocomplete="off" maxlength="255">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="unit-of-measurement">Unit of Measurement</label>
                                <input id="unit-of-measurement" type="text" class="form-control" v-model="salesItemPrice.unit_of_measurement.name" autocomplete="off" maxlength="255">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="price">Price</label>
                                <input id="price" type="number" class="form-control" v-model="salesItemPrice.price" autocomplete="off" minlength="2" maxlength="255" step=".01" placeholder="0.00" required>
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
                ifReady:           false,
                action:            'View',
                title:             'View Sales Item Price',
                singularName:      'Sales Item Price',
                pluralName:        'Sales Item Prices',
                apiPath:           '/api/sales-item-prices',
                routePrefixName:   'sales-item-prices',
                useName:           'singular',
                selectedProperty:  'price',
                toastMessage:      'Sales item price',
                salesItemPrice: {}
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get(this.apiPath + '/' + this.$route.params.id).then(res => {
                    this.salesItemPrice = res.data.sales_item_price;
                    
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
