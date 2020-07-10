<template>
    <div class="card">
        <div class="card-header">
            <router-link class="text-primary" :to="{ name: 'item-types.index' }">Items</router-link>
            /
            <span class="text-secondary">Edit Item</span>
        </div>
        <div class="card-body">
            <div v-if="ifReady">
                <form v-on:submit.prevent="updateItem()">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" v-model="name" autocomplete="off" minlength="2" maxlength="255" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Stock Keeping Unit</label>
                                <input class="form-control" v-model="stock_keeping_unit" maxlength="1000" required></input>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Identifier</label>
                                <input class="form-control" v-model="identifier" maxlength="1000"></input>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" v-model="description" maxlength="1000"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label>Item Type</label>
                            <vue-select v-model="itemType" @input="selectItemType()" label="name" :options="itemTypes"></vue-select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Item Classification</label>
                            <vue-select v-model="itemClassification" @input="selectItemClassification()" label="name" :options="itemClassifications"></vue-select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Unit of Measurement</label>
                            <vue-select v-model="unitOfMeasurement" @input="selectUnitOfMeasurement()" label="name" :options="unitOfMeasurements"></vue-select>
                        </div>

                        <div class="col-md-3 form-group">
                            <label>Brand</label>
                            <vue-select v-model="brand" @input="selectBrand()" label="name" :options="brands"></vue-select>
                        </div>

                        <div class="col-md-6 form-group" v-if="brand != null">
                            <label>Purchase Discounts</label>
                            <span v-for="(purchase_discount, index) in purchase_discounts" :key="index">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">%</div>
                                    </div>
                                    <input type="text" class="form-control" v-model="purchase_discount.discount">
                                </div>
                                <br>
                            </span>
                        </div>

                        <div class="col-md-6 form-group" v-if="brand != null">
                            <label>Sales Discounts</label>
                            <span v-for="(sales_discount, index) in sales_discounts" :key="index">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">%</div>
                                    </div>
                                    <input type="text" class="form-control" v-model="sales_discount.discount">
                                </div>
                                <br>
                            </span>
                        </div>
                    </div>

                    <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'items.index' }"><i class="fas fa-chevron-left"></i>&nbsp; Back</router-link>
                    <button type="submit" class="btn btn-success btn-sm" ><i class="fas fa-edit"></i>&nbsp; Update Item</button>
                </form>
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
                name: "",
                stock_keeping_unit: "",
                identifier: "",
                description: "",
                itemTypes: [],
                itemType: null,
                item_type_id: "",
                itemClassifications: [],
                itemClassification: null,
                item_classification_id: "",
                unitOfMeasurements: [],
                unitOfMeasurement: null,
                default_unit_of_measurement_id: "",
                brands: [],
                brand: null,
                brand_id: "",
                purchase_discounts: [
                    { discount: 0 },
                    { discount: 0 },
                    { discount: 0 },
                    { discount: 0 },
                    { discount: 0 }
                ],
                sales_discounts: [
                    { discount: 0 },
                    { discount: 0 },
                    { discount: 0 },
                    { discount: 0 },
                    { discount: 0 }
                ]
            };
        },

        mounted() {
            let promiseGetItemTypes = new Promise((resolve, reject) => {
                axios.get("/api/item-types/get-all-item-types").then(res => {
                    this.itemTypes = res.data.item_types;
                    resolve();
                }).catch(err => {
                    console.log(err);
                    reject();
                });
            });

            let promiseGetItemClassifications = new Promise((resolve, reject) => {
                axios.get("/api/item-classifications/get-all-item-classifications").then(res => {
                    this.itemClassifications = res.data.item_classifications;
                    resolve();
                }).catch(err => {
                    console.log(err);
                    reject();
                });
            });

            let promiseGetUnitOfMeasurements = new Promise((resolve, reject) => {
                axios.get("/api/unit-of-measurements/get-all-unit-of-measurements").then(res => {
                    this.unitOfMeasurements = res.data.unit_of_measurements;
                    resolve();
                }).catch(err => {
                    console.log(err);
                    reject();
                });
            });

            let promiseGetBrands = new Promise((resolve, reject) => {
                axios.get("/api/brands/get-all-brands").then(res => {
                    this.brands = res.data.brands;
                    resolve();
                }).catch(err => {
                    console.log(err);
                    reject();
                });
            });

            let promiseGetItem = new Promise((resolve, reject) => {
                axios.get("/api/items/" + this.$route.params.id).then(res => {
                    this.name                           = res.data.item.name;
                    this.description                    = res.data.item.description;
                    this.stock_keeping_unit             = res.data.item.stock_keeping_unit;
                    this.identifier                     = res.data.item.identifier;
                    this.itemType                       = res.data.item.item_type;
                    this.item_type_id                   = res.data.item.item_type_id;
                    this.itemClassification             = res.data.item.item_classification;
                    this.item_classification_id         = res.data.item.item_classification_id;
                    this.unitOfMeasurement              = res.data.item.default_unit_of_measurement;
                    this.default_unit_of_measurement_id = res.data.item.default_unit_of_measurement_id;
                    this.brand                          = res.data.item.brand;
                    this.brand_id                       = res.data.item.brand_id;
                    this.purchase_discounts             = res.data.item.purchase_discounts;
                    this.sales_discounts                = res.data.item.sales_discounts;
                    
                    resolve();
                }).catch(err => {
                    reject();
                    console.log(err);
                });
            });

            Promise.all([
                promiseGetItemTypes,
                promiseGetItemClassifications,
                promiseGetUnitOfMeasurements,
                promiseGetBrands,
                promiseGetItem
            ]).then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            selectItemType() {
                this.item_type_id = this.itemType.id;
            },
            selectItemClassification() {
                this.item_classification_id = this.itemClassification.id;
            },
            selectUnitOfMeasurement() {
                this.default_unit_of_measurement_id = this.unitOfMeasurement.id;
            },
            selectBrand() {
                this.brand_id           = this.brand.id;
                this.purchase_discounts = this.brand.purchase_discounts;
                this.sales_discounts    = this.brand.sales_discounts;
            },
            updateItem() {
                this.ifReady = false;

                let formData = {
                    brand_id: this.brand_id,
                    item_type_id: this.item_type_id,
                    item_classification_id: this.item_classification_id,
                    default_unit_of_measurement_id: this.default_unit_of_measurement_id,
                    name: this.name,
                    description: this.description,
                    stock_keeping_unit: this.stock_keeping_unit,
                    identifier: this.identifier,
                    purchase_discounts: this.purchase_discounts,
                    sales_discounts: this.sales_discounts
                };

                axios.patch("/api/items/" + this.$route.params.id, formData).then(res => {
                    this.$router.push({
                        name: "items.view",
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
