<template>
    <div>
        <div class="card">
            <div class="card-header">
                <router-link class="text-primary" :to="{ name: 'settings.index' }">Settings</router-link>
                /
                <router-link class="text-primary" :to="{ name: 'corporations.index' }">Corporations</router-link>
                /
                <span class="text-secondary">View Corporation</span>
            </div>
            <div class="card-body">
                <div v-if="ifReady">
                    <fieldset disabled>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" v-model="corporation.name">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" v-model="corporation.description"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input type="text" class="form-control" v-model="corporation.street">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" v-model="corporation.city">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" v-model="corporation.state">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="zip_code">Zip Code</label>
                                    <input type="text" class="form-control" v-model="corporation.zip_code">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" v-model="corporation.country">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fax">Fax</label>
                                    <input type="text" class="form-control" v-model="corporation.fax">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <router-link class="btn btn-outline-secondary btn-sm" :to="{ name: 'corporations.index' }"><i class="fas fa-chevron-left"></i>&nbsp; Back</router-link>
                    <button type="button" class="btn btn-primary btn-sm" @click.prevent.default="editCorporation"><i class="fas fa-edit"></i>&nbsp;  Edit Corporation</button>
                    <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="openDeleteCorporationModal"><i class="fas fa-trash-alt"></i>&nbsp; Delete Corporation</button>
                </div>
                <div v-else>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteCorporationModal" tabindex="-1" role="dialog" aria-labelledby="deleteCorporationTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">You're about to delete this Corporation?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Corporation? <br><br>
                        Deleting this {{componentVal}} will delete the following data <br><br>
                        - departments <br>
                        - sub-departments <br>
                        - budgets <br>
                        - journals <br>
                        - journal entries <br>
                        - vouchers <br>
                        - voucher entries <br>
                        - statistics <br>
                        - metrics <br><br>

                        that are all related to this Corporation.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="deleteCorporation">Confirm Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
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
                corporation: ''
            };
        },

        mounted() {
            let promise = new Promise((resolve, reject) => {
                axios.get('/api/corporations/' + this.$route.params.id).then(res => {
                    this.corporation = res.data.corporation;
                    resolve();
                });
            });

            promise.then(() => {
                this.ifReady = true;
            });
        },

        methods: {
            viewCorporations() {
                this.$router.push({
                    name: 'corporations.index'
                });
            },
            editCorporation() {
                this.$router.push({
                    name: 'corporations.edit',
                    params: { id: this.corporation.id }
                });
            },
            openDeleteCorporationModal() {
                $('#deleteCorporationModal').modal('show');
            },
            deleteCorporation() {
                $('#deleteCorporationModal').modal('hide');

                axios.delete('/api/corporations/' + this.$route.params.id).then(res => {
                    this.$router.push({ name: 'corporations.index' });
                }).catch(err => {
                    console.log(err);
                });
            }
        }
    }
</script>
