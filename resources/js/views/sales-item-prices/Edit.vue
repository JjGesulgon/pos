<template>
    <div>
        <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

        <div class="card">
            <div class="card-body">
                <form-title :routePrefixName="routePrefixName" :title="title" v-bind:showRightSide="false"></form-title>
                <br>
                <form-edit :apiPath="apiPath" :routePrefixName="routePrefixName" :singularName="singularName" :toastMessage="toastMessage" :fieldColumns="getFieldColumns()">
                    <template>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="item">Item <small class="text-danger">* Required</small></label>
                                <search idAttribute="item" apiPath="/api/items/search" styleClass="form-control" labelAttribute="name" searchColumn="name" placeholder="Search Items" :selectedObject="$data.salesItemPrice.item" @SelectOption="selectItem($event)"></search>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="measuring-mass">Measuring Mass <small class="text-danger">* Required</small></label>
                                <search idAttribute="measuring-mass" apiPath="/api/measuring-mass/search" styleClass="form-control" labelAttribute="mass" searchColumn="mass" placeholder="Search Measuring Mass" :selectedObject="$data.salesItemPrice.measuring_mass" @SelectOption="selectMeasuringMass($event)"></search>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="unit-of-measurement">Unit of Measurement <small class="text-danger">* Required</small></label>
                                <search idAttribute="unit-of-measurement" apiPath="/api/unit-of-measurements/search" styleClass="form-control" labelAttribute="name" searchColumn="name" placeholder="Search Unit of Measurements" :selectedObject="$data.salesItemPrice.unit_of_measurement" @SelectOption="selectUnitOfMeasurement($event)"></search>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="price">Price <small class="text-danger">* Required</small></label>
                                <input id="price" type="number" class="form-control" v-model="$data.price" autocomplete="off" minlength="2" maxlength="255" step=".01" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="is-default" v-model="is_default">
                                    <label class="form-check-label" for="is-default"><strong>Make Default Purchase Item Price</strong></label>
                                </div>
                            </div>
                        </div>
                    </template>
                </form-edit>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ifReady:               false,
                action:                'Edit',
                title:                 'Edit New Sales Item Price',
                singularName:          'Sales Item Price',
                pluralName:            'Sales Item Prices',
                apiPath:               '/api/sales-item-prices',
                routePrefixName:       'sales-item-prices',
                useName:               'singular',
                selectedProperty:      'name',
                toastMessage:          'Sales item price',
                item_id:                null,
                measuring_mass_id:      null,
                unit_of_measurement_id: null,
                price:                  null,
                is_default:             null,
                salesItemPrice: {
                    item: { name: '' },
                    measuring_mass: { mass: '' },
                    unit_of_measurement: { name: '' }
                }
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get(this.apiPath + '/' + this.$route.params.id).then(res => {
                    this.item_id                = res.data.sales_item_price.item.id;
                    this.measuring_mass_id      = res.data.sales_item_price.measuring_mass.id;
                    this.unit_of_measurement_id = res.data.sales_item_price.unit_of_measurement.id;
                    this.price                  = res.data.sales_item_price.price;
                    this.is_default             = res.data.sales_item_price.is_default;

                    this.salesItemPrice.item                = res.data.sales_item_price.item;
                    this.salesItemPrice.measuring_mass      = res.data.sales_item_price.measuring_mass;
                    this.salesItemPrice.unit_of_measurement = res.data.sales_item_price.unit_of_measurement;

                    resolve();
                }).catch(err => {
                    reject();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            getFieldColumns() {
                return {
                    item_id:                this.item_id,
                    measuring_mass_id:      this.measuring_mass_id,
                    unit_of_measurement_id: this.unit_of_measurement_id,
                    price:                  this.price,
                    is_default:             this.is_default
                }
            },
            selectItem(item) {
                this.item_id = item.id;
            },
            selectMeasuringMass(measuringMass) {
                this.measuring_mass_id = measuringMass.id;
            },
            selectUnitOfMeasurement(unitOfMeasurement) {
                this.unit_of_measurement_id = unitOfMeasurement.id;
            }
        }
    }
</script>
