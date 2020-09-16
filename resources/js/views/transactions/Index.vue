<template>
    <div>
        <breadcrumbs :routePrefixName="routePrefixName" :action="action" :singularName="singularName" :pluralName="pluralName" :useName="useName"></breadcrumbs>

        <div class="card">
            <div class="card-body">
                <form-title :routePrefixName="routePrefixName" :title="title" :singularName="singularName" :pluralName="pluralName" v-bind:showRightSide="true" :parameters="getParameters()"></form-title>
                <br>
                <data-table :pluralName="pluralName">
                    <template v-slot:thead>
                        <tr>
                            <th scope="col">From</th>
                            <th scope="col">Number</th>
                            <th scope="col">Reference Number</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Grand Total Amount</th>
                            <th scope="col">Date Issued</th>
                            <th scope="col">Action</th>
                        </tr>
                    </template>
                    <template v-slot:tbody v-bind:data="$data">
                        <tr :id="transaction.id" :key="transaction.id" v-for="transaction in data.data">
                            <td>{{ transaction.transactionable_from_type }} {{ transaction.transactionable_from.name }}</td>
                            <td>{{ transaction.number }}</td>
                            <td>{{ transaction.reference_number }}</td>
                            <td>{{ transaction.contact | ContactFormat }}</td>
                            <td>{{ transaction.grand_total_amount }}</td>
                            <td>{{ transaction.created_at | DateFormat }}</td>
                            <td><data-table-row-action :routePrefixName="routePrefixName" :object="transaction" :disableEdit="true"></data-table-row-action></td>
                        </tr>
                    </template>
                </data-table>
            </div>
        </div>

        <br>
        
        <pagination v-if="data" :routeName="routeName" :meta="data.meta" :links="data.links" :parameters="getParameters()"></pagination>

        <search-modal v-if="data" :routeName="routeName" idAttribute="search-modal" ref="searchModal" :title="singularName" :parameters="getParameters()" @ClearParameters="clearParameters()">
            <template v-bind:data="$data">
                <div class="row">
                    <!-- <div class="col-md-6 form-group">
                    </div> -->
                    <div class="col-md-6 form-group">
                        <label id="customer">Customer</label>
                        <input id="customer" type="text" class="form-control" v-model="$data.name_from_contact">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-6 form-group">
                        <label for="number">Number</label>
                        <input id="number" type="text" class="form-control" v-model="$data.number">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="reference-number">Reference Number</label>
                        <input id="reference-number" type="text" class="form-control" v-model="$data.reference_number">
                    </div>
                </div>
            </template>
        </search-modal>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                action:            'View',
                title:             'Transactions',
                singularName:      'Transaction',
                pluralName:        'Transactions',
                apiPath:           '/api/transactions',
                routeName:         'transactions.index',
                routePrefixName:   'transactions',
                useName:           'plural',
                showProgress:      false,
                data:              null,
                order_by:          'desc',
                name_from_contact: null,
                number:            null,
                reference_number:  null
            };
        },

        beforeRouteEnter(to, from, next) {
            if (to.query.per_page == null) {
                next(vm => vm.getData({
                    page:              to.query.page,
                    per_page:          15,
                    name_from_contact: to.query.name_from_contact,
                    number:            to.query.number,
                    reference_number:  to.query.reference_number,
                    order_by:          to.query.order_by
                }));
            } else {
                next(vm => vm.getData({
                    page:              to.query.page,
                    per_page:          to.query.per_page,
                    name_from_contact: to.query.name_from_contact,
                    number:            to.query.number,
                    reference_number:  to.query.reference_number,
                    order_by:          to.query.order_by
                }));
            }
        },

        beforeRouteUpdate(to, from, next) {
            this.getData({
                page:              to.query.page,
                per_page:          this.data.meta.per_page,
                name_from_contact: this.name_from_contact,
                number:            this.number,
                reference_number:  this.reference_number,
                order_by:          this.order_by
            });

            next();
        },

        filters: {
            Upper(value) {
                return value.toUpperCase();
            },
            ContactFormat: function (contact) {
                if (contact.company !== null) {
                    return contact.company;
                } else {
                    return contact.name;
                }
            },
            DateFormat: function (date) {
                if (date) {
                    return moment(date).format('MMMM Do YYYY, h:mm A');
                }
            }
        },

        methods: {
            getData(params) {
                this.showProgress      = true;
                this.name_from_contact = params.name_from_contact;
                this.number            = params.number;
                this.reference_number  = params.reference_number;
                
                (typeof params.order_by === 'undefined' || params.order_by == 'desc') ? this.order_by = 'desc' : this.order_by = 'asc';

                axios.get(this.apiPath, { params }).then(res => {
                    this.data         = res.data;
                    this.data.data    = res.data.data;

                    let transactionableFrom = {
                        'App\\Branch': 'Branch',
                        'App\\Warehouse': 'Warehouse',
                    };

                    this.data.data.map(transaction => {
                        transaction.transactionable_from_type = transactionableFrom[transaction.transactionable_from_type];
                    });

                    this.showProgress = false;
                }).catch(error => {
                    if (error.response.status == 401) {
                        location.reload();
                    }

                    if (error.response.status == 500) {
                        alert('Kindly report this issue to the devs.');
                    }
                });
            },
            getParameters() {
                return {
                    name_from_contact: this.name_from_contact,
                    number:            this.number,
                    reference_number:  this.reference_number,
                    order_by:          this.order_by
                };
            },
            clearParameters() {
                this.name_from_contact = '';
                this.number            = '';
                this.reference_number  = '';
                this.order_by          = 'desc';
            }
        }
    }
</script>

