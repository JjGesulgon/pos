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
                            <div class="col-md-6 form-group">
                    <label for="from">
                        From
                        &nbsp;
                        <div class="form-check form-check-inline">
                            <div>
                                <input id="from-branch" type="radio" v-model="from_selected_radio_button" value="branch"/>
                                <label for="from-branch" class="form-check-label">&nbsp; Branch</label>
                            </div>
                        </div>
                        <div class="form-check form-check-inline">
                            <div>
                                <input id="from-warehouse" type="radio" v-model="from_selected_radio_button" value="warehouse"/>
                                <label for="from-warehouse" class="form-check-label">&nbsp; Warehouse</label>
                            </div>
                        </div>
                    </label>
                    <div class="input-group">
                        <search apiPath="/api/branches/search" idAttribute="from" styleClass="form-control" labelAttribute="name" searchColumn="name" placeholder="Search Branches" v-show="from_selected_radio_button === 'branch'" :selectedObject="branch" @SelectOption="selectFromBranch($event)"></search>
                        <search apiPath="/api/warehouses/search" idAttribute="from" styleClass="form-control" labelAttribute="name" searchColumn="name" placeholder="Search Warehouses" v-show="from_selected_radio_button === 'warehouse'" @SelectOption="selectFromWarehouse($event)"></search>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Number Slip</div>
                        </div>
                        <input id="number" type="text" class="form-control" v-model="$data.number" readonly required />
                    </div>
                </div>
                <div class="col-md-6 form-group">
                    <label id="contact">Contact</label>
                    <div class="input-group">
                        <search apiPath="/api/contacts/search" idAttribute="contact" styleClass="form-control" labelAttribute="name" searchColumn="name" placeholder="Search Contacts" :selectedObject="contact" @SelectOption="selectContact($event)"></search>
                        <div class="input-group-prepend">
                            <div class="input-group-text">Reference Number</div>
                        </div>
                        <input id="reference-number" type="text" class="form-control" v-model="$data.reference_number" readonly required/>
                    </div>
                </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="discountableSwitch" @change="toggleIfDiscountable()">
                                    <label class="custom-control-label" for="discountableSwitch">Check if Discountable</label>
                                </div>

                                <br v-if="is_discountable">

                                <div class="row" v-if="is_discountable">
                                    <div class="col-2">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="default-discount" class="custom-control-input" v-model="discount_type" value="Total">
                                            <label class="custom-control-label" for="default-discount">Total</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="item-discount" class="custom-control-input" v-model="discount_type" value="Per Item">
                                            <label class="custom-control-label" for="item-discount">Per Item</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="brand-discount" class="custom-control-input" v-model="discount_type" value="Per Brand">
                                            <label class="custom-control-label" for="brand-discount">Per Brand</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="mixed-discount" class="custom-control-input" v-model="discount_type" value="Mixed">
                                            <label class="custom-control-label" for="mixed-discount">Mixed</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group" v-if="is_discountable">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon">Discount %</div>
                                            </div>
                                            <input type="number" class="form-control" min="0" max="100" v-model="discount_percent">
                                        </div>
                                    </div>

                                    <br v-if="is_discountable">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="taxable-switch" :checked="is_taxable" @change="toggleIfTaxable()">
                                            <label class="custom-control-label" for="taxable-switch">Check if Taxable</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div v-if="is_taxable" class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is-tax-inclusive" :checked="is_tax_inclusive" @change="toggleIsTaxInclusive()">
                                            <label class="custom-control-label" for="is-tax-inclusive">Is Tax Inclusive (Included)</label>
                                        </div>
                                    </div>
                                </div>

                                <br v-if="is_taxable">

                                <div class="row" v-if="is_taxable">
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="default-tax" class="custom-control-input" v-model="tax_type" value="Total">
                                            <label class="custom-control-label" for="default-tax">Total</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="item-tax" class="custom-control-input" v-model="tax_type" value="Per Item">
                                            <label class="custom-control-label" for="item-tax">Per Item</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group" v-if="is_taxable && (tax_type == 'Total' || tax_type == 'Mixed')">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon">Tax %</div>
                                            </div>
                                            <input type="number" class="form-control" min="0" max="100" v-model="tax_percent">
                                        </div>
                                    </div>
                                </div>

                                <br v-if="is_taxable">
                            </div>
                        </div>

                        <table class="table table-hover table-sm">
                            <caption>List of Quotation Items</caption>
                            <thead class="thead-light">
                                <tr>
                                    <th width="13%" scope="col">Stock Keeping Unit</th>
                                    <th width="20%" scope="col">Item</th>
                                    <th width="12%" scope="col">Measuring Mass</th>
                                    <th width="13%" scope="col">Unit of Measurement</th>
                                    <th width="12%" scope="col">Price</th>
                                    <th width="10%" scope="col">Quantity</th>
                                    <th width="10%" scope="col">Sub Total Amount</th>
                                    <th scope="col" v-if="is_discountable && (discount_type == 'Per Item' || discount_type == 'Mixed')">
                                        Item Discount
                                    </th>
                                    <th scope="col" v-if="is_discountable && (discount_type == 'Per Brand' || discount_type == 'Mixed')">
                                        Brand Discount
                                    </th>
                                    <th scope="col" v-if="is_taxable && (tax_type == 'Per Item' || tax_type == 'Mixed')">
                                        Tax
                                    </th>
                                    <th width="10%" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr :id="transaction_item.id" :key="transaction_item.id" v-for="(transaction_item, index) in transaction_items">
                                    <td>{{ transaction_item.item.stock_keeping_unit }}</td>
                                    <td>
                                        <search :idAttribute="index" apiPath="/api/items/search-for-sales" styleClass="form-control" labelAttribute="name_identifier" searchColumn="name" placeholder="Search Items" @SelectOption="selectItem($event, index)"></search>
                                    </td>
                                    <td>
                                        <search idAttribute="measuring-mass" apiPath="/api/measuring-mass/search" styleClass="form-control" labelAttribute="mass" searchColumn="mass" placeholder="Search Measuring Mass" :selectedObject="transaction_item.measuringMass" @SelectOption="selectMeasuringMass($event, index)"></search>
                                    </td>
                                    <td>
                                        <search idAttribute="unit-of-measurement" apiPath="/api/unit-of-measurements/search" styleClass="form-control" labelAttribute="name" searchColumn="name" placeholder="Search Unit of Measurements" :selectedObject="transaction_item.unitOfMeasurement" @SelectOption="selectUnitOfMeasurement($event, index)"></search>
                                    </td>
                                    <td>
                                        <search idAttribute="sales-item-price" apiPath="/api/sales-item-prices/search" styleClass="form-control" labelAttribute="price" searchColumn="price" placeholder="Search Sales Item Prices" :selectedObject="transaction_item.salesItemPrice" :additionalParameters="additionalParametersForSearchingSalesItemPrices(index)" @SelectOption="selectSalesItemPrice($event, index)"></search>
                                    </td>
                                    <td>
                                        <input class="form-control" v-model.number="transaction_item.quantity" required>
                                    </td>
                                    <td>{{ sub_total_amount[index] | Decimal }}</td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Item' || discount_type == 'Mixed')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" :id="'item_discount_' + index" v-model="transaction_item.enable_individual_item_discount" @click="enableIndividualItemDiscount(index)">
                                            <label class="custom-control-label" :for="'item_discount_' + index">
                                                {{ transaction_item.item_discount_amount }}
                                            </label>
                                        </div>
                                    </td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Brand' || discount_type == 'Mixed')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" :id="'brand_discount_' + index" @click="enableIndividualBrandDiscount(index)">
                                            <label class="custom-control-label" :for="'brand_discount_' + index"></label>
                                        </div>
                                    </td>
                                    <td scope="row" v-if="is_taxable && (tax_type == 'Per Item' || tax_type == 'Mixed')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" :id="'tax_' + index" @click="enableIndividualTaxDiscount(index)">
                                            <label class="custom-control-label" :for="'tax_' + index"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" @click="removeItem(index)"><i class="far fa-times-circle"></i>&nbsp; Remove Item</button>
                                    </td>
                                </tr>

                                <tr>
                                    <td scope="row" colspan="7">&nbsp;</td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Item' || discount_type == 'Mixed')">&nbsp;</td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Brand' || discount_type == 'Mixed')">&nbsp;</td>
                                    <td scope="row" v-if="is_taxable && (tax_type == 'Per Item' || tax_type == 'Mixed')">&nbsp;</td>
                                    <td scope="row" colspan="1"></td>
                                </tr>
                                <tr>
                                    <td scope="row" colspan="5"></td>
                                    <td scope="row">
                                        <b>Total Amount</b>
                                    </td>
                                    <td scope="row"><strong>{{ total_amount | Decimal }}</strong></td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Item' || discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Brand' || discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="is_taxable && (tax_type == 'Per Item' || tax_type == 'Mixed')"></td>
                                    <td scope="row" colspan="1"></td>
                                </tr>
                                <tr>
                                    <td scope="row" colspan="5"></td>
                                    <td scope="row">
                                        <b>Discount Amount</b>
                                    </td>
                                    <td scope="row"><strong>{{ discount_amount | Decimal }}</strong></td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Item' || discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Brand' || discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="is_taxable && (tax_type == 'Per Item' || tax_type == 'Mixed')"></td>
                                    <td scope="row" colspan="1"></td>
                                </tr>
                                <tr>
                                    <td scope="row" colspan="5"></td>
                                    <td scope="row">
                                        <b>Tax Amount</b>
                                    </td>
                                    <td scope="row"><strong>{{ tax_amount | Decimal }}</strong></td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Item' || discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Brand' || discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="is_taxable && (tax_type == 'Per Item' || tax_type == 'Mixed')"></td>
                                    <td scope="row" colspan="1"></td>
                                </tr>
                                <tr>
                                    <td scope="row" colspan="5"></td>
                                    <td scope="row">
                                        <b>Grand Total Amount</b>
                                    </td>
                                    <td scope="row"><strong>{{ grand_total_amount | Decimal }}</strong></td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Item' || discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="is_discountable && (discount_type == 'Per Brand' || discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="is_taxable && (tax_type == 'Per Item' || tax_type == 'Mixed')"></td>
                                    <td scope="row" colspan="1"></td>
                                </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-slot:other-buttons v-bind:addTransactionItem="addTransactionItem" v-bind:ifReady="ifReady">
                        <button type="button" class="btn btn-primary btn-sm" v-if="ifReady" @click="addTransactionItem"><i class="fas fa-plus-circle"></i>&nbsp; Add New Item</button>
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
                ifReady:                    true,
                action:                     'Create New',
                title:                      'Create New Transaction',
                singularName:               'Transaction',
                pluralName:                 'Transactions',
                apiPath:                    '/api/transactions',
                routePrefixName:            'transactions',
                useName:                    'singular',
                toastMessage:               'Transaction',
                from_selected_radio_button: 'branch',
                isDisabled:                 true,
                contact: {
                    id: 1,
                    name: 'Guest'
                },
                contact_id:                 1,
                branch: {
                    id: 1,
                    name: 'PDLPharmacy Circumferencial Road'
                },
                transactionable_from_id :          1,
                transactionable_from_type:         'App\\Branch',
                number:                     null,
                reference_number:           null,
                is_discountable:            false,
                discount_type:              'Total',
                discount_percent:           0,
                is_taxable:                 true,
                is_tax_inclusive:           true,
                tax_type:                   'Total',
                tax_percent:                12,
                transaction_items: [
                    {
                        item:                            '',
                        item_id:                         '',
                        measuringMass:                   '',
                        measuring_mass_id:               '',
                        unitOfMeasurement:               '',
                        unit_of_measurement_id:          '',
                        salesItemPrice:                  '',
                        sales_item_price_id:             '',
                        quantity:                        '',
                        item_discounts:                  [],
                        brand_discounts:                 [],
                        sub_total_amount:                '',
                        enable_individual_item_discount: false
                    }
                ]
            };
        },

        mounted() {
            Broadcast.$on("NewTransactionNumberGenerated", (event) => {
                this.number = event.number;
            });

            Broadcast.$on("NewTransactionReferenceNumberGenerated", (event) => {
                this.reference_number = event.referenceNumber;
            });

            this.number  = 'Generating New Number Slip';
            this.$generate.number('transaction', { branch_id: this.branch.id });

            this.reference_number = 'Generating New Reference Number';
            this.$generate.referenceNumber("transaction", { contact_id: this.contact.id });
        },

        filters: {
            Decimal: function (value) {
                if (value) {
                    return value.toFixed(2);
                }
            }
        },

        computed: {
            sub_total_amount: function() {
                return this.transaction_items.map((transaction_item) => {
                    return transaction_item.sub_total_amount = (transaction_item.quantity * transaction_item.salesItemPrice.price);
                });
            },
            total_amount: function () {
                return this.transaction_items.reduce((totalAmount, transaction_item) => {
                    if (transaction_item.quantity >= 1 && transaction_item.salesItemPrice.hasOwnProperty('price')) {
                        return totalAmount += (transaction_item.quantity * transaction_item.salesItemPrice.price);
                    }

                    return totalAmount;
                }, 0);
            },
            discount_amount: function() {
                if (this.discount_percent >= 1 && this.discount_percent <= 100 && this.is_discountable) {
                    let total_amount = 0;

                    total_amount = this.transaction_items.reduce((totalAmount, transaction_item) => {
                        if (transaction_item.quantity >= 1 && transaction_item.salesItemPrice.hasOwnProperty('price')) {
                            return totalAmount += (transaction_item.quantity * transaction_item.salesItemPrice.price);
                        }

                        return totalAmount;
                    }, 0);

                    return total_amount * (this.discount_percent / 100);
                }

                return 0;
            },
            tax_amount() {
                if (this.tax_percent >= 1 && this.tax_percent <= 100 && this.is_taxable) {
                    let total_amount = 0;

                    total_amount = this.transaction_items.reduce((totalAmount, transaction_item) => {
                        if (transaction_item.quantity >= 1 && transaction_item.salesItemPrice.hasOwnProperty('price')) {
                            return totalAmount += (transaction_item.quantity * transaction_item.salesItemPrice.price);
                        }

                        return totalAmount;
                    }, 0);

                    return total_amount * (this.tax_percent / 100);
                }

                return 0;
            },
            grand_total_amount: function () {
                let amount = this.total_amount;

                if (this.discount_amount >= 1 && this.discount_percent >= 1) {
                    amount = amount - this.discount_amount;
                }

                if (this.tax_amount >= 1 && this.tax_percent >= 1) {
                    if (! this.is_tax_inclusive) {
                        amount = amount + this.tax_amount;
                    }
                }

                return amount;
            }
        },

        methods: {
            getFieldColumns() {
                let transactionItems = [];

                this.transaction_items.forEach(transaction_item => {
                    transactionItems.push({
                        item_id:                transaction_item.item_id,
                        measuring_mass_id:      transaction_item.measuring_mass_id,
                        unit_of_measurement_id: transaction_item.unit_of_measurement_id,
                        sales_item_price_id:    transaction_item.sales_item_price_id,
                        quantity:               transaction_item.quantity
                    });
                });

                let formData = {
                    contact_id:         this.contact_id,
                    transactionable_from_id:   this.transactionable_from_id,
                    transactionable_from_type: this.transactionable_from_type,
                    number:             this.number,
                    reference_number:   this.reference_number,
                    total_amount:       this.total_amount,
                    grand_total_amount: this.grand_total_amount,
                    transaction_items:    transactionItems
                };

                let discountType;
                let taxType;

                if (this.is_discountable) {
                    if (this.discount_type == 'Total') {
                        discountType = 1;
                    } else if (this.discount_type == 'Per Item') {
                        discountType = 2;
                    } else if (this.discount_type == 'Per Brand') {
                        discountType = 3;
                    } else {
                        discountType = 4;
                    }

                    formData.is_discountable  = this.is_discountable;
                    formData.discount_type    = discountType;
                    formData.discount_percent = this.discount_percent;
                    formData.discount_amount  = this.discount_amount;
                }

                if (this.is_taxable) {
                    if (this.tax_type == 'Total') {
                        taxType = 1;
                    } else if (this.tax_type == 'Per Item') {
                        taxType = 2;
                    } else if (this.tax_type == 'Per Brand') {
                        taxType = 3;
                    } else {
                        taxType = 4;
                    }

                    formData.is_taxable       = this.is_taxable;
                    formData.is_tax_inclusive = this.is_tax_inclusive;
                    formData.tax_type         = taxType;
                    formData.tax_percent      = this.tax_percent;
                    formData.tax_amount       = this.tax_amount;
                }

                return formData;
            },
            selectContact(contact) {
                if (typeof contact === 'object') {
                    this.reference_number = 'Generating New Reference Number';
                    this.contact          = contact;
                    this.contact_id       = contact.id;

                    this.$generate.referenceNumber("transaction", { contact_id: contact.id });
                }
            },
            selectFromWarehouse(warehouse) {
                if (typeof warehouse === 'object') {
                    this.transactionable_from_id   = warehouse.id;
                    this.transactionable_from_type = "App\\Warehouse";
                    this.number                    = 'Generating New Number Slip';

                    this.$generate.number("transaction", { warehouse_id: warehouse.id });
                }
            },
            selectFromBranch(branch) {
                if (typeof branch === 'object') {
                    this.branch                    = branch;
                    this.transactionable_from_id   = branch.id;
                    this.transactionable_from_type = "App\\Branch";
                    this.number                    = 'Generating New Number Slip';

                    this.$generate.number('transaction', { branch_id: branch.id });
                }
            },
            selectItem(item, index) {
                this.transaction_items[index].item                   = item;
                this.transaction_items[index].item_id                = item.id;
                this.transaction_items[index].measuringMass          = item.default_sales_item_price.measuring_mass;
                this.transaction_items[index].measuring_mass_id      = item.default_sales_item_price.measuring_mass.id;
                this.transaction_items[index].unitOfMeasurement      = item.default_sales_item_price.unit_of_measurement;
                this.transaction_items[index].unit_of_measurement_id = item.default_sales_item_price.unit_of_measurement.id;
                this.transaction_items[index].salesItemPrice         = item.default_sales_item_price;
                this.transaction_items[index].sales_item_price_id    = item.default_sales_item_price_id;
            },
            selectMeasuringMass(measuringMass, index) {
                this.transaction_items[index].measuringMass     = measuringMass;
                this.transaction_items[index].measuring_mass_id = measuringMass.id;
            },
            selectUnitOfMeasurement(unitOfMeasurement, index) {
                this.transaction_items[index].unitOfMeasurement      = unitOfMeasurement;
                this.transaction_items[index].unit_of_measurement_id = unitOfMeasurement.id;
            },
            additionalParametersForSearchingSalesItemPrices(index) {
                if (typeof this.transaction_items[index].item === 'object') {
                    return {
                        item_id:                this.transaction_items[index].item_id,
                        measuring_mass_id:      this.transaction_items[index].measuring_mass_id,
                        unit_of_measurement_id: this.transaction_items[index].unit_of_measurement_id,
                        is_strict:              'true'
                    };
                }
            },
            selectSalesItemPrice(salesItemPrice, index) {
                this.transaction_items[index].salesItemPrice      = salesItemPrice;
                this.transaction_items[index].sales_item_price_id = salesItemPrice.id;
            },
            selectPurchaseOrderItem(index) {
                if (this.transaction_items[index].item instanceof Object) {
                    this.transaction_items[index].item_id                = this.transaction_items[index].item.id;
                    this.transaction_items[index].unitOfMeasurement      = this.transaction_items[index].item.default_unit_of_measurement.name;
                    this.transaction_items[index].unit_of_measurement_id = this.transaction_items[index].item.default_unit_of_measurement.id;
                }
            },
            selectPurchaseOrderPrice(index) {
                if (this.transaction_items[index].item instanceof Object) {
                    this.transaction_items[index].sales_item_price_id = this.transaction_items[index].salesItemPrice.id;
                }
            },
            addTransactionItem() {
                this.transaction_items.push({
                    item:                            '',
                    item_id:                         '',
                    measuringMass:                   '',
                    measuring_mass_id:               '',
                    unitOfMeasurement:               '',
                    unit_of_measurement_id:          '',
                    salesItemPrice:                  '',
                    sales_item_price_id:             '',
                    item_discounts:                  [],
                    brand_discounts:                 [],
                    quantity:                        '',
                    sub_total_amount:                '',
                    enable_individual_item_discount: false
                });
            },
            removeItem(index) {
                this.transaction_items.splice(index, 1);
            },
            toggleIfDiscountable() {
                if (this.is_discountable) {
                    this.is_discountable = false;
                } else {
                    this.is_discountable = true;
                }
            },
            toggleIfTaxable() {
                if (this.is_taxable) {
                    this.is_taxable = false;
                } else {
                    this.is_taxable = true;
                }
            },
            toggleIsTaxInclusive() {
                if (this.is_tax_inclusive) {
                    this.is_tax_inclusive = false;
                } else {
                    this.is_tax_inclusive = true;
                }
            },
            enableIndividualItemDiscount(index) {
                if (typeof this.transaction_items[index].item === 'object') {
                    if (this.transaction_items[index].enable_individual_item_discount) {
                        this.transaction_items[index].enable_individual_item_discount = false;
                    } else {
                        this.transaction_items[index].enable_individual_item_discount = true;
                    }

                    let totalDiscountedAmount = 0;
                    let remainder             = null;
                    let transactionItem         = this.transaction_items[index];
                    let itemDiscounts         = [];
                    let temporaryQuantity     = transactionItem.quantity;

                    this.transaction_items[index].item.sales_discounts.forEach(sales_discount => {
                        if (sales_discount.quantity >= 1 && sales_discount.discount >= 1) {
                            itemDiscounts.push(sales_discount);    
                        }
                    });

                    itemDiscounts.reverse();

                    // if (true) {
                    //     this.transaction_items[index].
                    // }

                    // if (true) {

                    // }

                    console.log("Item Discounts: ", itemDiscounts);

                    itemDiscounts.forEach((sales_discount, index) => {
                        if (temporaryQuantity >= sales_discount.quantity && remainder == null) {
                            remainder = temporaryQuantity % sales_discount.quantity;
                            let totalQuantity = Math.floor((temporaryQuantity / sales_discount.quantity));

                            for (let i = totalQuantity - 1; i >= 0; i--) {
                                let totalAmount = sales_discount.quantity * transactionItem.salesItemPrice.price;
                                totalDiscountedAmount += totalAmount * (sales_discount.discount / 100);
                            }

                            console.log("First Final Discounted Amount: ", totalDiscountedAmount, " Remainder: ", remainder);
                            console.log("Grand Total Amount: ", (this.grand_total_amount - totalDiscountedAmount));
                        } else if (remainder != null && remainder >= sales_discount.quantity) {
                            console.log("Remainder: ", remainder, " Sales Quantity: ", sales_discount.quantity);
                            let totalQuantity = Math.floor((remainder / sales_discount.quantity));
                            remainder = remainder % sales_discount.quantity;
                            console.log("Remainder: ", remainder);
                            console.log("Total Rotation for Discount", totalQuantity);

                            for (let i = totalQuantity - 1; i >= 0; i--) {
                                let totalAmount = sales_discount.quantity * transactionItem.salesItemPrice.price;
                                console.log("Total Discounted Amount: ", totalAmount);
                                totalDiscountedAmount += totalAmount * (sales_discount.discount / 100);
                            }

                            console.log("Succeding Final Discounted Amount: ", totalDiscountedAmount, " Remainder: ", remainder);
                            console.log("Grand Total Amount: ", (this.grand_total_amount - totalDiscountedAmount));
                        }
                    });

                    // console.log("Item Discounts: ", this.transaction_items[index].item.sales_discounts);
                    // console.log("Brand Discounts: ", this.transaction_items[index].item.brand.sales_discounts);
                }
            },
            enableIndividualBrandDiscount(index) {
                console.log('enableIndividualBrandDiscount');
                console.log(this.transaction_items[index]);
            },
            enableIndividualTaxDiscount(index) {
                console.log('enableIndividualTaxDiscount');
                console.log(this.transaction_items[index]);
            }
        }
    }
</script>

