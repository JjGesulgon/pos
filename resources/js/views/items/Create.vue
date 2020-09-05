<template>
    <div>
        <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

        <div class="card">
            <div class="card-body">
                <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>
                <br>
                <form-create :apiPath="apiPath" :routePrefixName="routePrefixName" :singularName="singularName" :toastMessage="toastMessage" :fieldColumns="getFieldColumns()">
                    <template v-bind:data="$data">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Name <small class="text-danger">* Required</small></label>
                                    <input id="name" type="text" class="form-control" v-model="name" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="stock-keeping-unit">Stock Keeping Unit <small class="text-danger">* Required</small></label>
                                    <input id="stock-keeping-unit" class="form-control" v-model="stock_keeping_unit" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="universal-product-code">Universal Product Code</label>
                                    <input id="universal-product-code" class="form-control" v-model="universal_product_code" autocomplete="off" minlength="2" maxlength="255" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="identifier">Identifier</label>
                                    <input id="identifier" class="form-control" v-model="identifier" autocomplete="off" maxlength="255">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" v-model="description" maxlength="1000"></textarea>
                                </div>
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="item-classification">Item Classification <small class="text-danger">* Required</small></label>
                                <search idAttribute="item-classification" apiPath="/api/item-classifications/search" styleClass="form-control" labelAttribute="display_name" searchColumn="display_name" placeholder="Search Item Classifications" @SelectOption="selectItemClassification($event)"></search>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="item-type">Item Type <small class="text-danger">* Required</small></label>
                                <search idAttribute="item-type" apiPath="/api/item-types/search" styleClass="form-control" labelAttribute="display_name" searchColumn="display_name" placeholder="Search Item Types" @SelectOption="selectItemType($event)"></search>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="brand">Brand <small class="text-danger">* Required</small></label>
                                <search idAttribute="brand" apiPath="/api/brands/search" styleClass="form-control" labelAttribute="display_name" searchColumn="display_name" placeholder="Search Brands" @SelectOption="selectBrand($event)"></search>
                            </div>

                            <div class="col-md-6 form-group" v-if="purchase_discounts != null">
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
                            <div class="col-md-6 form-group" v-if="sales_discounts != null">
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
                    </template>
                </form-create>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady:                true,
                action:                 'Create New',
                title:                  'Create New Item',
                singularName:           'Item',
                pluralName:             'Items',
                apiPath:                '/api/items',
                routePrefixName:        'items',
                useName:                'singular',
                toastMessage:           'Item',
                name:                   null,
                stock_keeping_unit:     null,
                universal_product_code: null,
                identifier:             null,
                description:            null,
                item_type_id:           null,
                item_classification_id: null,
                brand_id:               null,
                purchase_discounts:     null,
                sales_discounts:        null
            };
        },

        methods: {
            getFieldColumns() {
                return {
                    brand_id:               this.brand_id,
                    item_type_id:           this.item_type_id,
                    item_classification_id: this.item_classification_id,
                    name:                   this.name,
                    description:            this.description,
                    stock_keeping_unit:     this.stock_keeping_unit,
                    universal_product_code: this.universal_product_code,
                    identifier:             this.identifier,
                    purchase_discounts:     this.purchase_discounts,
                    sales_discounts:        this.sales_discounts
                };
            },
            selectItemType(itemType) {
                this.item_type_id = itemType.id;
            },
            selectItemClassification(itemClassification) {
                this.item_classification_id = itemClassification.id;
            },
            selectBrand(brand) {
                this.brand_id           = brand.id;
                this.purchase_discounts = this.purchase_discounts;
                this.sales_discounts    = this.sales_discounts;
            }
        }
    }
</script>

