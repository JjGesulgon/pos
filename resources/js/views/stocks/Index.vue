<template>
    <div>
        <div class="card">
            <div class="card-header clearfix">
                <router-link class="text-primary" :to="{ name: 'receive-orders.index' }">Stocks</router-link>
                /
                <span class="text-secondary">View Stocks</span>
            </div>
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-warehouse-tab" data-toggle="tab" href="#nav-warehouse" role="tab" aria-controls="nav-warehouse" aria-selected="true" @click="changeTab('warehouse')">Warehouse</a>
                        <a class="nav-item nav-link" id="nav-branch-tab" data-toggle="tab" href="#nav-branch" role="tab" aria-controls="nav-branch" aria-selected="false" @click="changeTab('branch')">Branch</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <!-- Warehouse List -->
                    <div class="tab-pane fade show active" id="nav-warehouse" role="tabpanel" aria-labelledby="nav-warehouse-tab">
                        <table class="table table-hover table-sm">
                            <caption>
                                <div class="row">
                                    <div class="col-md-9">
                                        List of Stocks - Total Items {{ this.meta.total }}
                                    </div>
                                    <div class="col-md-3">
                                        <div class="progress" height="30px;" v-if="showProgress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </caption>
                            <thead>
                                <tr>
                                    <th scope="col">Stock From</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit of Measurement</th>
                                    <th scope="col">Options</th>
                                </tr>
                            </thead>
                            <tbody v-if="stocks">
                                <tr v-for="{ id, stockable_id, stockable, item, quantity, unit_of_measurement } in stocks">
                                    <td>{{ stockable.name }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>{{ quantity }}</td>
                                    <td>{{ unit_of_measurement.name }}</td>
                                    <td>
                                        <router-link class="text-secondary" :to="{ name: 'stocks.view', params: { id: id }}"><i class="fas fa-envelope-open-text"></i> View</router-link>
                                        <!-- <router-link class="btn-success btn-sm" :to="{ name: '', params: { id: id }}">Convert</router-link> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Branch List -->
                    <div class="tab-pane fade" id="nav-branch" role="tabpanel" aria-labelledby="nav-branch-tab">
                        <table class="table table-hover table-sm">
                            <caption>
                                <div class="row">
                                    <div class="col-md-9">
                                        List of Stocks - Total Items {{ this.meta.total }}
                                    </div>
                                    <div class="col-md-3">
                                        <div class="progress" height="30px;" v-if="showProgress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </caption>
                            <thead>
                                <tr>
                                    <th scope="col">Stock From</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Unit of Measurement</th>
                                    <th scope="col">Options</th>
                                </tr>
                            </thead>
                            <tbody v-if="stocks">
                                <tr v-for="{ id, stockable_id, stockable, item, quantity, unit_of_measurement } in stocks">
                                    <td>{{ stockable.name }}</td>
                                    <td>{{ item.name }}</td>
                                    <td>{{ quantity }}</td>
                                    <td>{{ unit_of_measurement.name }}</td>
                                    <td>
                                        <router-link class="text-secondary" :to="{ name: 'stocks.view', params: { id: id }}"><i class="fas fa-envelope-open-text"></i> View</router-link>
                                        <!-- <router-link class="btn-success btn-sm" :to="{ name: '', params: { id: id }}">Convert</router-link> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>

        <br>

        <div class="clearfix">
            <div v-if="pageCount">
                <nav class="float-left">
                    <ul class="pagination">
                        <li class="page-item" v-bind:class="isPrevDisabled">
                            <a class="page-link" href="#" @click.prevent="goToPreviousPage" disabled>Previous</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" @click.prevent="goToFirstPage">First</a>
                        </li>
                        <li class="page-item" v-for="pageNumber in pageNumbers" v-bind:class="isPageActive(pageNumber)">
                            <a class="page-link" href="#" @click.prevent="goToPage(pageNumber)">{{ pageNumber }}</a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToLastPage">Last</a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToNextPage">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div v-else>
                <nav class="float-left">
                    <ul class="pagination">
                        <li class="page-item" v-bind:class="isPrevDisabled">
                            <a class="page-link" href="#" @click.prevent="goToPreviousPage" disabled>Previous</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" @click.prevent="goToFirstPage">First</a>
                        </li>
                        <li class="page-item" v-for="pageNumber in pageNumbers" v-bind:class="isPageActive(pageNumber)">
                            <a class="page-link" href="#" @click.prevent="goToPage(pageNumber)">{{ pageNumber }}</a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToLastPage">Last</a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToNextPage">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="float-right">
                <form class="form-inline">
                    <!-- <button type="button" class="btn btn-primary mr-2" @click.prevent.default="openSearchModal">Search Warehouses</button> -->
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Items per page</div>
                        </div>
                        <select class="custom-select" id="number_of_items" v-model="meta.per_page" v-on:change="changePerPage">
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchWarehouses" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Search Warehouses</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" v-model="name" autocomplete="off" minlength="2" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" v-model="address" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" v-model="city" autocomplete="off" minlength="2" maxlength="255" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" v-model="country" autocomplete="off" minlength="2" maxlength="255" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="zip_code">Zip Code</label>
                                <input type="text" class="form-control" v-model="zip_code" autocomplete="off" minlength="2" maxlength="255" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="telephone_number">Telephone Number</label>
                                <input type="text" class="form-control" v-model="telephone_number" autocomplete="off" minlength="2" maxlength="255" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Order By</label>
                            <select class="form-control" v-model="order_by">
                                <option value="desc">Newest</option>
                                <option value="asc">Oldest</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="clear">Clear</button>
                        <button type="button" class="btn btn-success btn-sm" @click.prevent.default="search">Search</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const getWarehouses = (
        page,
        per_page,
        name,
        address,
        city,
        country,
        zip_code,
        telephone_number,
        order_by,
        callback,
        route = 'warehouse'
        ) => {
        const params = {
            page,
            per_page,
            name,
            address,
            city,
            country,
            zip_code,
            telephone_number,
            order_by
        };

        axios.get(`/api/stocks/get-all-stocks/${route}`, { params }).then(res => {

            console.log('Stocks: ' , JSON.parse(JSON.stringify(res.data)));

            const {path, current_page, data, first_page_url, from, last_page, last_page_url, next_page_url, per_page, prev_page_url, to, total} = res.data.stocks

            const response = {
                data:data,
                links:{
                    first:first_page_url,
                    last:last_page_url,
                    next:next_page_url,
                    prev:prev_page_url
                },
                meta:{
                    current_page:1,
                    from:from,
                    last_page:last_page,
                    path:path,
                    per_page:per_page,
                    to:to,
                    total:total
                }
            }
            callback(null, response);

        }).catch(error => {
            switch (error.response.status) {
                case  401 :
                location.reload()
                break;
                case 500 :
                alert('Kindly report this issue to the devs.');
                break;
            }
        });
    };

    export default {
        data() {
            return {
                warehouses: null,
                name: '',
                address: '',
                city: '',
                country: '',
                zip_code: '',
                telephone_number: '',
                order_by: 'desc',
                meta: {
                    current_page: null,
                    from: null,
                    last_page: null,
                    path: null,
                    per_page: 10,
                    to: null,
                    total: null
                },
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },
                error: null,
                showProgress: false,
                pageNumbers: [],
                stocks:''
            };
        },

        beforeRouteEnter (to, from, next) {
            if (to.query.per_page == null) {
                getWarehouses(
                    to.query.page,
                    10,
                    to.query.name,
                    to.query.address,
                    to.query.city,
                    to.query.country,
                    to.query.zip_code,
                    to.query.telephone_number,
                    to.query.order_by,
                    (err, data) => {
                        next(vm => vm.setData(err, data));
                    }
                    );
            } else {
                getWarehouses(
                    to.query.page,
                    to.query.per_page,
                    to.query.name,
                    to.query.address,
                    to.query.city,
                    to.query.country,
                    to.query.zip_code,
                    to.query.telephone_number,
                    to.query.order_by,
                    (err, data) => {
                        next(vm => vm.setData(err, data));
                    }
                    );
            }
        },

        beforeRouteUpdate (to, from, next) {
            getWarehouses(
                to.query.page,
                this.meta.per_page,
                this.name,
                this.address,
                this.city,
                this.country,
                this.zip_code,
                this.telephone_number,
                this.order_by,
                (err, data) => {
                    this.setData(err, data);
                    next();
                }
                );
        },

        computed: {
            nextPage() {
                return this.meta.current_page + 1;
            },
            prevPage() {
                return this.meta.current_page - 1;
            },
            paginatonCount() {
                if (! this.meta) {
                    return;
                }

                const { current_page, last_page } = this.meta;

                return `${current_page} of ${last_page}`;
            },
            pageCount() {
                if (this.meta.last_page > 10) {
                    return false;
                }

                return true;
            },
            isPrevDisabled() {
                if (this.links.prev == null) {
                    return 'disabled';
                }

                return;
            },
            isNextDisabled() {
                if (this.links.next == null) {
                    return 'disabled';
                }

                return;
            }
        },

        methods: {
            changeTab( tab ='warehouse') {
                getWarehouses(
                    this.prevPage,
                    this.meta.per_page,
                    this.name,
                    this.address,
                    this.city,
                    this.country,
                    this.zip_code,
                    this.telephone_number,
                    this.order_by,
                    (err, data) => {
                        this.setData(err, data)
                    },
                    tab
                    );
            },
            goToFirstPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'stocks.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        name: this.name,
                        address: this.address,
                        city: this.city,
                        country: this.country,
                        zip_code: this.zip_code,
                        telephone_number: this.telephone_number,
                        order_by: this.order_by
                    },
                });
            },
            goToPage(page = null) {
                this.showProgress = true;
                this.$router.push({
                    name: 'stocks.index',
                    query: {
                        page,
                        per_page: this.meta.per_page,
                        name: this.name,
                        address: this.address,
                        city: this.city,
                        country: this.country,
                        zip_code: this.zip_code,
                        telephone_number: this.telephone_number,
                        order_by: this.order_by
                    },
                });
            },
            goToLastPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'stocks.index',
                    query: {
                        page: this.meta.last_page,
                        per_page: this.meta.per_page,
                        name: this.name,
                        address: this.address,
                        city: this.city,
                        country: this.country,
                        zip_code: this.zip_code,
                        telephone_number: this.telephone_number,
                        order_by: this.order_by
                    },
                });
            },
            goToNextPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'stocks.index',
                    query: {
                        page: this.nextPage,
                        per_page: this.meta.per_page,
                        name: this.name,
                        address: this.address,
                        city: this.city,
                        country: this.country,
                        zip_code: this.zip_code,
                        telephone_number: this.telephone_number,
                        order_by: this.order_by
                    },
                });
            },
            goToPreviousPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'stocks.index',
                    query: {
                        page: this.prevPage,
                        per_page: this.meta.per_page,
                        name: this.name,
                        address: this.address,
                        city: this.city,
                        country: this.country,
                        zip_code: this.zip_code,
                        telephone_number: this.telephone_number,
                        order_by: this.order_by
                    }
                });
            },
            setData(err, { data: stocks, links, meta }) {
                this.pageNumbers = [];

                if (err) {
                    this.error = err.toString();
                } else {
                    this.stocks = stocks;
                    this.links = links;
                    this.meta = meta;
                }

                this.showProgress = false;
                this.populatePages();
            },
            populatePages() {
                if (this.pageCount) {
                    for (let i = 1; i <= this.meta.last_page; i++) {
                        this.pageNumbers.push(i);
                    }
                } else if (this.meta.current_page <= 6) {
                    let page = 1;
                    this.pageNumbers.push(page);
                    this.pageNumbers.push(page + 1);
                    this.pageNumbers.push(page + 2);
                    this.pageNumbers.push(page + 3);
                    this.pageNumbers.push(page + 4);
                    this.pageNumbers.push(page + 5);
                    this.pageNumbers.push(page + 6);
                    this.pageNumbers.push('...');
                    this.pageNumbers.push(this.meta.last_page - 1);
                    this.pageNumbers.push(this.meta.last_page);
                } else if ((this.meta.current_page + 6) >= this.meta.last_page) {
                    this.pageNumbers.push(1);
                    this.pageNumbers.push(2);
                    this.pageNumbers.push('...');
                    this.pageNumbers.push(this.meta.last_page - 7);
                    this.pageNumbers.push(this.meta.last_page - 6);
                    this.pageNumbers.push(this.meta.last_page - 5);
                    this.pageNumbers.push(this.meta.last_page - 4);
                    this.pageNumbers.push(this.meta.last_page - 3);
                    this.pageNumbers.push(this.meta.last_page - 2);
                    this.pageNumbers.push(this.meta.last_page - 1);
                    this.pageNumbers.push(this.meta.last_page);
                } else {
                    this.pageNumbers.push(1);
                    this.pageNumbers.push(2);
                    this.pageNumbers.push('...');
                    this.pageNumbers.push(this.meta.current_page - 2);
                    this.pageNumbers.push(this.meta.current_page - 1);
                    this.pageNumbers.push(this.meta.current_page);
                    this.pageNumbers.push(this.meta.current_page + 1);
                    this.pageNumbers.push(this.meta.current_page + 2);
                    this.pageNumbers.push('...');
                    this.pageNumbers.push(this.meta.last_page - 1);
                    this.pageNumbers.push(this.meta.last_page);
                }
            },
            isPageActive(page) {
                if (page == this.$route.query.page || (page == 1 && this.$route.query.page == null)) {
                    return 'active';
                }

                return;
            },
            changePerPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'stocks.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        name: this.name,
                        address: this.address,
                        city: this.city,
                        country: this.country,
                        zip_code: this.zip_code,
                        telephone_number: this.telephone_number,
                        order_by: this.order_by
                    }
                });
            },search() {
                $('#searchModal').modal('hide');
                this.showProgress = true;
                this.$router.push({
                    name: 'stocks.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        name: this.name,
                        address: this.address,
                        city: this.city,
                        country: this.country,
                        zip_code: this.zip_code,
                        telephone_number: this.telephone_number,
                        order_by: this.order_by
                    }
                });
            },
            clear() {
                this.name             = '';
                this.address          = '';
                this.city             = '';
                this.country          = '';
                this.zip_code         = '';
                this.telephone_number = '';
                this.order_by         = 'desc';
            },
            openSearchModal() {
                $('#searchModal').modal('show');
            }
        }
    }
</script>
