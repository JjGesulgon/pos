<template>
    <div>
        <div class="card">
            <div class="card-header clearfix">
                <div class="float-left">
                    <router-link class="text-primary" :to="{ number: 'transaction_history.index' }">Transaction History</router-link>
                    /
                    <span class="text-secondary">View Transaction History</span>
                </div>
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" @click.prevent.default="openSearchModal()">
                        <i class="fas fa-search"></i>&nbsp;
                        Search Transaction History
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover table-sm">
                    <caption>
                        <div class="row">
                            <div class="col-md-9">
                                List of Transactions - Total Items {{ this.meta.total }}
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
                            <th scope="col">Transaction Number</th>
                            <th scope="col">Total Revenue</th>
                            <th scope="col">Transaction Date</th>
                            <th scope="col">Options</th>
                        </tr>
                    </thead>
                    <tbody v-if="transaction_history">
                        <tr v-for="transaction in transaction_history">
                            <td>{{ transaction.number }}</td>
                            <td>{{ transaction.total_amount }}</td>
                            <td>{{ formatDate(transaction.created_at) }}</td>
                            <td>
                                <label class="text-secondary clickableText" @click.prevent.default="openTransactionItemModal(transaction.id)">
                                    <i class="fas fa-eye"></i>&nbsp;
                                    <strong>View</strong>
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>

        <div class="clearfix">
            <div v-if="pageCount">
                <nav class="float-left">
                    <ul class="pagination">
                        <li class="page-item" v-bind:class="isPrevDisabled">
                            <a class="page-link" href="#" @click.prevent="goToPreviousPage" disabled><strong>Previous</strong></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" @click.prevent="goToFirstPage"><strong>First</strong></a>
                        </li>
                        <li class="page-item" v-for="pageNumber in pageNumbers" v-bind:class="isPageActive(pageNumber)">
                            <a class="page-link" href="#" @click.prevent="goToPage(pageNumber)"><strong>{{ pageNumber }}</strong></a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToLastPage"><strong>Last</strong></a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToNextPage"><strong>Next</strong></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div v-else>
                <nav class="float-left">
                    <ul class="pagination">
                        <li class="page-item" v-bind:class="isPrevDisabled">
                            <a class="page-link" href="#" @click.prevent="goToPreviousPage" disabled><strong>Previous</strong></a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" @click.prevent="goToFirstPage"><strong>First</strong></a>
                        </li>
                        <li class="page-item" v-for="pageNumber in pageNumbers" v-bind:class="isPageActive(pageNumber)">
                            <a class="page-link" href="#" @click.prevent="goToPage(pageNumber)"><strong>{{ pageNumber }}</strong></a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToLastPage"><strong>Last</strong></a>
                        </li>
                        <li class="page-item" v-bind:class="isNextDisabled">
                            <a class="page-link" href="#" @click.prevent="goToNextPage"><strong>Next</strong></a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="float-right">
                <form class="form-inline">
                    <label class="sr-only" for="number_of_items">Number of Item</label>
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

        <div class="modal fade" id="transaction-items-modal" tabindex="-1" role="dialog" aria-labelledby="transactionItems" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionItems">Transaction {{ transactionItems.number}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="col-md-12">
                        <div class="progress" height="30px;" v-if="ifReady">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-sm"  v-if="transactionItems">
                            <caption>
                                <div class="row">
                                    <!-- <div class="col-md-9">
                                        List of Transaction Items
                                    </div> -->
                                </div>
                            </caption>
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">qty</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="transaction in transactionItems.transaction_items">
                                    <td>{{ transaction.item.name }}</td>
                                    <td>{{ transaction.quantity }}</td>
                                    <td>{{ transaction.item.amount }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="float-right" v-if="transactionItems">
                            <div>
                                <strong>Total Revenue:</strong>
                                {{ transactionItems.total_amount }}
                            </div>
                        </div>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" @click.prevent.default="clear">Clear</button>
                        <button type="button" class="btn btn-success btn-sm" @click.prevent.default="search">Search</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="search" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="search">Search Transaction History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>number</label>
                            <input type="text" class="form-control" v-model="number" autocomplete="off" maxlength="255">
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control" v-model="total_amount" autocomplete="off" maxlength="255">
                        </div>
                        <div class="form-group">
                            <label>Order By</label>
                            <select class="form-control" v-model="order_by">
                                <option value="desc">Newest</option>
                                <option value="asc">Oldest</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
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
    const getTransaction = (page, per_page, number, total_amount, order_by, callback) => {
        const params = { page, per_page, number, total_amount, order_by };

        axios.get('/api/transactions', { params }).then(res => {
            callback(null, res.data);
        }).catch(error => {
            if (error.response.status == 401) {
                location.reload();
            }

            if (error.response.status == 500) {
                alert('Kindly report this issue to the devs.');
            }
        });
    };

    export default {
        data() {
            return {
                transaction_history: null,
                number: '',
                transactionItems: '',
                total_amount: '',
                transactionID: '',
                ifReady: false,
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
                pageNumbers: []
            };
        },

        beforeRouteEnter (to, from, next) {
            if (to.query.per_page == null) {
                getTransaction(to.query.page, 10, to.query.number, to.query.total_amount, to.query.order_by, (err, data) => {
                    next(vm => vm.setData(err, data));
                });
            } else {
                getTransaction(to.query.page, to.query.per_page, to.query.number, to.query.total_amount, to.query.order_by, (err, data) => {
                    next(vm => vm.setData(err, data));
                });
            }
        },

        beforeRouteUpdate (to, from, next) {
            getTransaction(to.query.page, this.meta.per_page, this.number, this.total_amount, this.order_by, (err, data) => {
                this.setData(err, data);
                next();
            });
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
            goToFirstPage() {
                this.showProgress = true;
                this.$router.push({
                    number: 'transaction_history.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        number: this.number,
                        total_amount: this.total_amount,
                        order_by: this.order_by
                    }
                });
            },
            goToPage(page = null) {
                this.showProgress = true;
                this.$router.push({
                    number: 'transaction_history.index',
                    query: {
                        page,
                        per_page: this.meta.per_page,
                        number: this.number,
                        total_amount: this.total_amount,
                        order_by: this.order_by
                    }
                });
            },
            goToLastPage() {
                this.showProgress = true;
                this.$router.push({
                    number: 'transaction_history.index',
                    query: {
                        page: this.meta.last_page,
                        per_page: this.meta.per_page,
                        number: this.number,
                        total_amount: this.total_amount,
                        order_by: this.order_by
                    }
                });
            },
            goToNextPage() {
                this.showProgress = true;
                this.$router.push({
                    number: 'transaction_history.index',
                    query: {
                        page: this.nextPage,
                        per_page: this.meta.per_page,
                        number: this.number,
                        total_amount: this.total_amount,
                        order_by: this.order_by
                    }
                });
            },
            goToPreviousPage() {
                this.showProgress = true;
                this.$router.push({
                    number: 'transaction_history.index',
                    query: {
                        page: this.prevPage,
                        per_page: this.meta.per_page,
                        number: this.number,
                        total_amount: this.total_amount,
                        order_by: this.order_by
                    }
                });
            },
            setData(err, { data: transaction, links, meta }) {
                this.pageNumbers = [];

                if (err) {
                    this.error = err.toString();
                } else {
                    this.transaction_history = transaction;
                    console.log(this.transaction_history);
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
                    number: 'transaction_history.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        number: this.number,
                        total_amount: this.total_amount,
                        order_by: this.order_by
                    }
                });
            },
            search() {
                $('#search-modal').modal('hide');
                this.showProgress = true;
                this.$router.push({
                    number: 'transaction_history.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        number: this.number,
                        total_amount: this.total_amount,
                        order_by: this.order_by
                    }
                });
            },
            clear() {
                this.number = '';
                this.total_amount = '';
                this.order_by = 'desc';
            },
            openSearchModal() {
                $('#search-modal').modal('show');
            },

            openTransactionItemModal(id){
                this.transactionItems = ''
                this.ifReady = true;
                $('#transaction-items-modal').modal('show');
                let promise = new Promise((resolve, reject) => {
                    axios.get('/api/transactions/' + id).then(res => {
                        this.transactionItems = res.data.transaction
                        resolve();
                    });
                });

                promise.then(() => {
                    this.ifReady = false;
                });
            },
            formatDate(dt) {
                let transactionDate = new Date(dt)
                let formatted_date = (transactionDate.getMonth() + 1) + "/" + transactionDate.getDate() + "/" + transactionDate.getFullYear()

                return formatted_date;
            },
        }
    }
</script>

<style scoped>
.clickableText:hover {
    text-decoration: underline;
    cursor: pointer
}
</style>>
