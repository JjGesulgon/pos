<template>
    <div>
        <div v-if="ifReady">
            <div class="card">
                <div class="card-header">
                    <router-link class="text-primary" :to="{ name: 'contacts.index' }">Contacts</router-link>
                    /
                    <span class="text-secondary">Edit Contact</span>
                </div>
                <div class="card-body">
                    <form v-on:submit.prevent="updateContact()">
                        <fieldset>
                            <legend>Contact Information</legend>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Contact Type</label>
                                    <vue-select v-model="contactType" @input="selectContactType()" label="display_name" :options="contactTypes"></vue-select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="company">Business Type</label>
                                    <input type="text" class="form-control" v-model="business_type" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" v-model="name" autocomplete="off">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="mobile_number">Mobile Number</label>
                                    <input type="text" class="form-control" v-model="mobile_number" autocomplete="off">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" v-model="email" autocomplete="off">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="company">City</label>
                                    <input type="text" class="form-control" v-model="city" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="company">Province</label>
                                    <input type="text" class="form-control" v-model="province" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" v-model="address" rows="2" autocomplete="off"></textarea>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend>Company Information</legend>
                            <div class="form-group">
                                <label for="company">Company Name</label>
                                <input type="text" class="form-control" v-model="company" autocomplete="off" minlength="2" maxlength="255">
                            </div>
                            <div class="form-group">
                                <label for="company_address">Company Address</label>
                                <textarea class="form-control" v-model="company_address" rows="2" autocomplete="off"></textarea>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend>Payment Information</legend>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="company">Bank Name</label>
                                    <input type="text" class="form-control" v-model="bank_name" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="company">Bank Account Number</label>
                                    <input type="text" class="form-control" v-model="bank_account_number" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="company">TIN Number</label>
                                    <input type="text" class="form-control" v-model="tin_number" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Payment Method</label>
                                    <vue-select v-model="mode_of_payment" @input="selectPaymentMethod()" label="name" :options="modeOfPayments"></vue-select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Credit Limit</label>
                                    <input type="number" class="form-control" v-model="credit_limit" min="0" max="99999999" required>
                                </div>
                                <div class="col-md-6 form-group" v-show="selectedBank">
                                    <label for="name">Bank</label>
                                    <input type="text" class="form-control" v-model="bank_name" autocomplete="off" minlength="2" maxlength="255">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Payment Term</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="optradio" v-model="payment_term" value="1">
                                        <label class="form-check-label">&nbsp; Partial</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="optradio" v-model="payment_term" value="2">
                                        <label class="form-check-label">&nbsp; Full</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'contacts.view', params: { id: id }}"><i class="fas fa-chevron-left"></i>&nbsp; Back</router-link>
                        <button type="button" class="btn btn-success btn-sm"><i class="fas fa-edit"></i>&nbsp; Update Contact</button>
                    </form>
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
                paymentMethodData: null,
                modeOfPayments: [],
                contactTypes: [],
                contactType: null,
                contact_type_id: '',
                id: '',
                type:'',
                name: '',
                mobile_number: '',
                email: '',
                city: '',
                province: '',
                address: '',
                business_type: '',
                company: '',
                company_address: '',
                mode_of_payment_id: '',
                bank_name: '',
                payment_term: '',
                credit_limit: '',
                mode_of_payment: '',
                mode_of_payment_id: '',
                selectedBank: null
            };
        },

        mounted() {
            let promiseGetContactTypes = new Promise((resolve, reject) => {
                axios.get('/api/contacts-type/get-all-contacts-type').then(res => {
                    this.contactTypes = res.data.contact_types;
                    resolve();
                }).catch(err => {
                    console.log(err);
                    reject();
                });
            });

            let promiseGetModeOfPayments = new Promise((resolve, reject) => {
                axios.get("/api/mode-of-payments/get-all-mode-of-payments/").then(res => {
                    this.modeOfPayments = res.data.mode_of_payments;
                    resolve();
                }).catch(err => {
                    console.log(err);
                    reject();
                });
            });

            let promiseGetContact = new Promise((resolve, reject) => {
                axios.get('/api/contacts/' + this.$route.params.id).then(res => {
                    this.id                  = res.data.contact.id;
                    this.contactType         = res.data.contact.contact_type;
                    this.contact_type_id     = res.data.contact.contact_type.id;
                    this.business_type       = res.data.contact.business_type;
                    this.name                = res.data.contact.name;
                    this.mobile_number       = res.data.contact.mobile_number;
                    this.email               = res.data.contact.email;
                    this.city                = res.data.contact.city;
                    this.province            = res.data.contact.province;
                    this.address             = res.data.contact.address;
                    this.company             = res.data.contact.company;
                    this.company_address     = res.data.contact.company_address;
                    this.bank_name           = res.data.contact.bank_name;
                    this.bank_account_number = res.data.contact.bank_account_number;
                    this.tin_number          = res.data.contact.tin_number;
                    this.payment_term        = res.data.contact.payment_term;
                    this.mode_of_payment     = res.data.contact.mode_of_payment;
                    this.credit_limit        = res.data.credit_limit;

                    resolve();
                }).catch(err => {
                    console.log(err);
                    reject();
                });
            });

            Promise.all([promiseGetContactTypes, promiseGetModeOfPayments, promiseGetContact]).then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            selectPaymentMethod() {
                this.mode_of_payment_id = this.mode_of_payment.id;
                
                if(this.mode_of_payment.id == 1){
                    this.selectedBank = false;
                    this.bank_name = '';
                } else if (this.mode_of_payment.id == 2) {
                    this.selectedBank = true;
                } else {
                    this.selectedBank = false;
                }
            },
            selectContactType() {
                this.contact_type_id = this.contactType.id;
            },
            updateContact() {
                this.ifReady = false;

                axios.patch('/api/contacts/' + this.$route.params.id, this.$data).then(res => {
                    this.$router.push({
                        name: 'contacts.view',
                        params: { id: this.$route.params.id }
                    });
                }).catch(err => {
                    this.ifReady = true;
                    console.log(err);
                    alert('Error');
                });
            }
        }
    }
</script>
