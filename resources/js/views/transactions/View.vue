<template>
    <div>
        <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

        <div class="card">
            <div class="card-body">
                <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>

                <br>

                <form-view :apiPath="apiPath" :routePrefixName="routePrefixName" :singularName="singularName" :object="transaction" :selectedProperty="selectedProperty" :toastMessage="toastMessage" :disableEdit="true" :disableDelete="true">
                    <template v-bind:transaction="transaction" v-bind:ifReady="ifReady">
                        <div v-if="ifReady" class="row">
                            <div class="col-md-6 form-group">
                                <label for="from">From {{ transaction.from_name }}</label>
                                <input id="from" type="text" class="form-control" v-model="transaction.transactionable_from.name" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="customer">Customer</label>
                                <input id="customer" type="text" class="form-control" v-model="transaction.contact.name" readonly>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="number">Number Slip</label>
                                <input id="number" type="text" class="form-control" v-model="transaction.number" readonly required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="reference-number">Reference Number</label>
                                <input id="reference-number" type="text" class="form-control" v-model="transaction.reference_number" readonly required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="discountable-switch" :checked="transaction.is_discountable">
                                    <label class="custom-control-label" for="discountableSwitch">Check if Discountable</label>
                                </div>

                                <br v-if="transaction.is_discountable">

                                <div class="row" v-if="transaction.is_discountable">
                                    <div class="col-2">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="brand-discount" class="custom-control-input" :checked="(transaction.discount_type == 1) ? true : false">
                                            <label class="custom-control-label" for="default-discount">Total</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="brand-discount" class="custom-control-input" :checked="(transaction.discount_type == 2) ? true : false">
                                            <label class="custom-control-label" for="item-discount">Per Item</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="brand-discount" class="custom-control-input" :checked="(transaction.discount_type == 3) ? true : false">
                                            <label class="custom-control-label" for="brand-discount">Per Brand</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="brand-discount" class="custom-control-input" :checked="(transaction.discount_type == 4) ? true : false">
                                            <label class="custom-control-label" for="mixed-discount">Mixed</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group" v-if="transaction.is_discountable && (transaction.discount_type == 1 || transaction.discount_type == 4)">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon">Discount %</div>
                                            </div>
                                            <input type="number" class="form-control" min="0" max="100" v-model="transaction.discount_percent">
                                        </div>
                                    </div>

                                    <br v-if="transaction.is_discountable">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="taxableSwitch" :checked="transaction.is_taxable">
                                            <label class="custom-control-label" for="taxable-switch">Check if Taxable</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div v-if="transaction.is_taxable" class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is-tax-inclusive" :checked="transaction.is_tax_inclusive">
                                            <label class="custom-control-label" for="is-tax-inclusive">Is Tax Inclusive (Included)</label>
                                        </div>
                                    </div>
                                </div>

                                <br v-if="transaction.is_taxable">

                                <div class="row" v-if="transaction.is_taxable">
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="item-tax" class="custom-control-input" :checked="(transaction.tax_type == 1) ? true : false">
                                            <label class="custom-control-label" for="default-tax">Total</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="item-tax" class="custom-control-input" :checked="(transaction.tax_type == 2) ? true : false">
                                            <label class="custom-control-label" for="item-tax">Per Item</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div v-if="transaction.is_taxable" class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon">Tax %</div>
                                            </div>
                                            <input type="number" class="form-control" min="0" max="100" v-model="transaction.tax_percent">
                                        </div>
                                    </div>
                                </div>

                                <br v-if="transaction.is_taxable">
                            </div>
                        </div>

                        <table v-if="ifReady" class="table table-hover table-sm">
                            <caption>List of transaction Items</caption>
                            <thead class="thead-light">
                                <tr>
                                    <th width="10%" scope="col">Stock Keeping Unit</th>
                                    <th width="20%" scope="col">Item</th>
                                    <th width="12%" scope="col">Measuring Mass</th>
                                    <th width="15%" scope="col">Unit of Measurement</th>
                                    <th width="13%" scope="col">Price</th>
                                    <th width="10%" scope="col">Quantity</th>
                                    <th width="10%" scope="col">Sub Total Amount</th>
                                    <th scope="col" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Item' || transaction.discount_type == 'Mixed')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="item-discount-all">
                                            <label class="custom-control-label" for="item-discount-all">Item Discount</label>
                                        </div>
                                    </th>
                                    <th scope="col" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Brand' || transaction.discount_type == 'Mixed')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-discount-all">
                                            <label class="custom-control-label" for="brand-discount-all">Brand Discount</label>
                                        </div>
                                    </th>
                                    <th scope="col" v-if="transaction.is_taxable && (transaction.tax_type == 'Per Item' || transaction.tax_type == 'Mixed')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="tax-all">
                                            <label class="custom-control-label" for="tax-all">Tax</label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr :id="transaction_item.id" :key="transaction_item.id" v-for="(transaction_item, index) in transaction.transaction_items">
                                    <td>{{ transaction_item.item.stock_keeping_unit }}</td>
                                    <td>{{ transaction_item.item.name }}</td>
                                    <td>{{ transaction_item.measuring_mass.mass }}</td>
                                    <td>{{ transaction_item.unit_of_measurement.name }}</td>
                                    <td>{{ transaction_item.sales_item_price.price }}</td>
                                    <td>{{ transaction_item.quantity }}</td>
                                    <td>{{ (transaction_item.quantity * transaction_item.sales_item_price.price) | Decimal }}</td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Item' || transaction.discount_type == 'Mixed')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" :id="'item_discount_' + index">
                                            <label class="custom-control-label" :for="'item_discount_' + index">
                                                {{ transaction_item.item_discount_amount }}
                                            </label>
                                        </div>
                                    </td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Brand' || transaction.discount_type == 'Mixed')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" :id="'brand_discount_' + index">
                                            <label class="custom-control-label" :for="'brand_discount_' + index"></label>
                                        </div>
                                    </td>
                                    <td scope="row" v-if="transaction.is_taxable && (transaction.tax_type == 'Per Item' || transaction.tax_type == 'Mixed')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" :id="'tax_' + index">
                                            <label class="custom-control-label" :for="'tax_' + index"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="row" colspan="7">&nbsp;</td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Item' || transaction.discount_type == 'Mixed')">&nbsp;</td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Brand' || transaction.discount_type == 'Mixed')">&nbsp;</td>
                                    <td scope="row" v-if="transaction.is_taxable && (transaction.tax_type == 'Per Item' || transaction.tax_type == 'Mixed')">&nbsp;</td>
                                </tr>
                                <tr class="bg-transparent">
                                    <td scope="row" colspan="5"></td>
                                    <td scope="row">
                                        <b>Total Amount</b>
                                    </td>
                                    <td scope="row"><strong>{{ transaction.total_amount }}</strong></td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Item' || transaction.discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Brand' || transaction.discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="transaction.is_taxable && (transaction.tax_type == 'Per Item' || transaction.tax_type == 'Mixed')"></td>
                                </tr>
                                <tr class="bg-transparent">
                                    <td scope="row" colspan="5"></td>
                                    <td scope="row">
                                        <b>Discount Amount</b>
                                    </td>
                                    <td scope="row"><strong>{{ transaction.discount_amount }}</strong></td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Item' || transaction.discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Brand' || transaction.discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="transaction.is_taxable && (transaction.tax_type == 'Per Item' || transaction.tax_type == 'Mixed')"></td>
                                </tr>
                                <tr class="bg-transparent">
                                    <td scope="row" colspan="5"></td>
                                    <td scope="row">
                                        <b>Tax Amount</b>
                                    </td>
                                    <td scope="row"><strong>{{ transaction.tax_amount }}</strong></td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Item' || transaction.discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Brand' || transaction.discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="transaction.is_taxable && (transaction.tax_type == 'Per Item' || transaction.tax_type == 'Mixed')"></td>
                                </tr>
                                <tr class="bg-transparent">
                                    <td scope="row" colspan="5"></td>
                                    <td scope="row">
                                        <b>Grand Total Amount</b>
                                    </td>
                                    <td scope="row"><strong>{{ transaction.grand_total_amount }}</strong></td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Item' || transaction.discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="transaction.is_discountable && (transaction.discount_type == 'Per Brand' || transaction.discount_type == 'Mixed')"></td>
                                    <td scope="row" v-if="transaction.is_taxable && (transaction.tax_type == 'Per Item' || transaction.tax_type == 'Mixed')"></td>
                                </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-slot:other-buttons v-bind:transaction="transaction" v-bind:ifReady="ifReady" v-bind:approvetransaction="approvetransaction">
                        <button class="btn btn-success btn-sm" v-if="transaction.status == 0 && ifReady" @click="approvetransaction">
                            <i class="fas fa-thumbs-up"></i>&nbsp; Approve transaction
                        </button>
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
                title:            'View Transaction',
                singularName:     'Transaction',
                pluralName:       'Transactions',
                apiPath:          '/api/transactions',
                routePrefixName:  'transactions',
                useName:          'singular',
                selectedProperty: 'name',
                toastMessage:     'Transaction',
                transaction:      {}
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get(this.apiPath + '/' + this.$route.params.id).then(res => {
                    this.transaction = res.data.transaction;

                    if (res.data.transaction.transactionable_from_type == 'App\\Branch') {
                        this.transaction.from_name = 'Branch';
                    } else {
                        this.transaction.from_name = 'Warehouse';
                    }

                    this.transaction.created_at = moment(this.transaction.created_at).format('MMMM Do YYYY, h:mm A');

                    resolve();
                }).catch(err => {
                    reject();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        filters: {
            Decimal: function (value) {
                if (value) {
                    return value.toFixed(2);
                }
            }
        }
    }
</script>
