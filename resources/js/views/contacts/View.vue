<template>
    <div>
        <div v-if="ifReady">
            <div class="card">
                <div class="card-header">
                    <router-link class="text-primary" :to="{ name: 'contacts.index' }">Contacts</router-link>
                    /
                    <span class="text-secondary">View Contact</span>
                </div>
                <div class="card-body">
                    <fieldset disabled>
                        <legend>Contact Information</legend>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Contact Type</label>
                                <input type="text" class="form-control" v-model="contact.contact_type.display_name"required></input>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="company_address">Business Type</label>
                                <input type="text" class="form-control" v-model="contact.business_type">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="contact.name" required></input>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="text" class="form-control" v-model="contact.mobile_number">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" v-model="contact.email">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="company">City</label>
                                <input type="text" class="form-control" v-model="contact.city" autocomplete="off" minlength="2" maxlength="255">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="company">Province</label>
                                <input type="text" class="form-control" v-model="contact.province" autocomplete="off" minlength="2" maxlength="255">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" v-model="contact.address" rows="2"></textarea>
                        </div>
                    </fieldset>

                    <br>

                    <fieldset disabled>
                        <legend>Company Information</legend>
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="text" class="form-control" v-model="contact.company">
                        </div>

                        <div class="form-group">
                            <label for="company_address">Company Address</label>
                            <textarea class="form-control" v-model="contact.company_address" rows="2"></textarea>
                        </div>
                    </fieldset>

                    <br>

                    <fieldset disabled>
                        <legend>Payment Information</legend>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="company">Bank Name</label>
                                <input type="text" class="form-control" v-model="contact.bank_name" autocomplete="off" minlength="2" maxlength="255">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="company">Bank Account Number</label>
                                <input type="text" class="form-control" v-model="contact.bank_account_number" autocomplete="off" minlength="2" maxlength="255">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="company">TIN Number</label>
                                <input type="text" class="form-control" v-model="contact.tin_number" autocomplete="off" minlength="2" maxlength="255">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="company_address">Payment Term</label>
                                <input type="text" class="form-control" v-model="contact.payment_term">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Credit Limit</label>
                                <input type="number" class="form-control" v-model="contact.credit_limit" min="0" max="99999999" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="company_address">Payment Method</label>
                                <input type="text" class="form-control" v-model="contact.mode_of_payment.name">
                            </div>
                        </div>
                    </fieldset>

                    <br>

                    <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'contacts.index' }"><i class="fas fa-chevron-left"></i> &nbsp;Back</router-link>
                    <router-link class="btn btn-primary btn-sm" :to="{ name: 'contacts.edit', params: { id: contact.id }}"><i class="fas fa-edit"></i> &nbsp;Edit</router-link>
                    <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="openDeleteContactModal()"><i class="fas fa-trash-alt"></i> &nbsp;Delete</button>
                </div>
            </div>

            <div class="modal fade" id="deleteContactModal" tabindex="-1" role="dialog" aria-labelledby="deleteContactTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">You're about to delete this contact?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this contact? <br><br>
                            Deleting this contact will delete the following data <br><br>

                            that are all related to this contact.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="deleteContact()">Confirm Delete</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
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
                contact: ''
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/contacts/' + this.$route.params.id).then(res => {
                    this.contact = res.data.contact;

                    if (res.data.contact.payment_term == 1) {
                        this.contact.payment_term = 'Partial';
                    } else {
                        this.contact.payment_term = 'Full';
                    }

                    resolve();
                }).catch(err => {
                    console.log(err);
                    reject();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            openDeleteContactModal() {
                $('#deleteContactModal').modal('show');
            },
            deleteContact() {
                $('#deleteContactModal').modal('hide');

                axios.delete('/api/contacts/' + this.$route.params.id).then((res) => {
                    this.$router.push({ name: 'contacts.index' });
                });
            }
        }
    }
</script>
