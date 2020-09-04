<template>
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <router-link class="text-primary" :to="{ name: 'transactions.index' }">Transactions</router-link>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Create New Transaction
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6">
            <div class="card" >
                <div class="card-header">
                    <div class="row clearfix">
                        <div class="float-left col-md-6">
                            Items
                        </div>
                        <div class="float-right col-md-6">
                            <input type="text" class="form-control form-control-sm" v-model="itemName" @input="onSearch" placeholder="Search Item">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm">
                        <caption>
                            <div class="row">
                                <div class="col-md-9">
                                    List of Items
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
                                <th width="35%" scope="col">Name</th>
                                <th width="25%" scope="col">Unit of Measurement</th>
                                <th width="15%" scope="col">Price</th>
                                <th width="25%" scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody v-if="items">
                            <tr v-for="item in items">
                                <td>{{ item.name }}</td>
                                <td>{{ item.default_unit_of_measurement.name }}</td>
                                <td>{{ item.default_sales_item_price.price }}</td>
                                <td>
                                    <div v-if="item.stocks_available != 0">
                                        <label class="text-secondary clickableText" @click.prevent.default="addToCart(item)">
                                            <i class="fas fa-cart-arrow-down"></i>&nbsp;
                                            <strong>Add to Cart</strong>
                                        </label>
                                    </div>
                                    <div v-else>
                                        <label class="text-danger">
                                            <i class="fas fa-exclamation-circle"></i>&nbsp;
                                            <strong>Not Available</strong>
                                        </label>
                                    </div>
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

            <div class="modal fade" id="checkout-modal" tabindex="-1" role="dialog" aria-labelledby="checkout" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="search">Confirm Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-hover table-sm card-title">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">qty</th>
                                        <th scope="col">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody v-if="cart">
                                    <tr v-for="item in cart">
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.amount }}</td>
                                        <td>{{ item.qty }}</td>
                                        <td>
                                            {{ (item.qty * item.amount).toFixed(2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card-text">
                                <br><br>
                                <div class="float-right">
                                    <div>
                                        <strong>Total Bill:</strong>
                                        {{ priceSummation() }}
                                    </div>
                                    <div>
                                        <strong>Cash:</strong>
                                        <input type="number" id="cash" name="cash" v-model="cash" disabled>
                                    </div>
                                    <div>
                                        <strong>Change:</strong>
                                        {{ (this.cash - priceSummation()).toFixed(2)}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container mb-4" v-if="this.ifReady">
                            <div class="progress" height="30px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                        <div class="modal-footer" v-else>
                            <button type="button" class="btn btn-success btn-sm" @click.prevent.default="createNewTransaction()">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><i class="fas fa-shopping-cart"></i>&nbsp; Cart</div>
                <div class="card-body">
                    <table class="table table-hover table-sm card-title">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">qty</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Options</th>
                            </tr>
                        </thead>
                        <tbody v-if="cart">
                            <tr v-for="item in cart">
                                <td>{{ item.name }}</td>
                                <td>{{ item.amount }}</td>
                                <td>
                                    <input type="number" id="qty" name="quantity" v-model="item.qty" v-bind:max="item.stocks_available">
                                </td>
                                <td>
                                    {{ (item.qty * item.amount).toFixed(2) }}
                                </td>
                                <td>
                                    <label class="text-danger clickableText" @click.prevent.default="removeFromCart(item)">
                                        <i class="fas fa-trash-alt"></i></i>&nbsp;
                                        <strong>Remove</strong>
                                    </label>
                                </td>
                            </tr>
                            <tr v-if="priceSummation() != 0">
                                <td scope="row" colspan="5"><br></td>
                            </tr>
                            <tr v-if="priceSummation() != 0">
                                <td scope="row" colspan="5"></td>
                            </tr>
                            <tr class="no-border" v-if="priceSummation() != 0">
                                <td scope="row" colspan="4"></td>
                                <td scope="row">
                                    <strong>Total Bill:</strong>
                                    {{ priceSummation() }}
                                </td>
                            </tr>
                            <tr class="no-border" v-if="priceSummation() != 0">
                                <td scope="row" colspan="4"></td>
                                <td scope="row">
                                    <strong>Cash:</strong>
                                    <input type="number" id="cash" name="cash" v-model="cash">
                                </td>
                            </tr>
                            <tr class="no-border" v-if="priceSummation() != 0">
                                <td scope="row" colspan="4"></td>
                                <td scope="row">
                                    <strong>Change:</strong>
                                    {{ (this.cash - priceSummation()).toFixed(2)}}
                                </td>
                            </tr>
                            <tr class="no-border" v-if="priceSummation() != 0">
                                <td scope="row" colspan="4"></td>
                                <td scope="row">
                                    <button type="button" class="btn btn-success btn-sm" @click.prevent.default="openCheckoutModal()">
                                        <i class="fas fa-cash-register"></i>&nbsp;
                                        Checkout
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const searchItemsForSales = (page, per_page, name, order_by, callback) => {
        const params = { page, per_page, name, order_by };

        axios.get('/api/items/search-for-sales', { params }).then(res => {
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
                items: null,
                name: '',
                itemName: '',
                cart: [],
                cash: 0,
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
                ifReady: false
            };
        },

        beforeRouteEnter (to, from, next) {
            if (to.query.per_page == null) {
                searchItemsForSales(
                    to.query.page,
                    10,
                    to.query.name,
                    to.query.order_by,
                    (err, data) => {
                        next(vm => vm.setData(err, data));
                    }
                    );
            } else {
                searchItemsForSales(
                    to.query.page,
                    to.query.per_page,
                    to.query.name,
                    to.query.order_by,
                    (err, data) => {
                        next(vm => vm.setData(err, data));
                    }
                    );
            }
        },

        beforeRouteUpdate (to, from, next) {
            searchItemsForSales(
                to.query.page,
                this.meta.per_page,
                this.name,
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
            },
            // subTotalAmount() {
            //     return this.purchase_order_items.map((purchase_order_item) => {
            //         return (purchase_order_item.quantity * purchase_order_item.unit_price);
            //     });
            // },
            // totalAmount() {
            //     return this.purchase_order_items.reduce((total, purchase_order_item) => {
            //         return total + (purchase_order_item.quantity * purchase_order_item.unit_price);
            //     }, 0);
            // }
        },

        methods: {
            goToFirstPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'transactions.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        name: this.name,
                        order_by: this.order_by
                    }
                });
            },
            goToPage(page = null) {
                this.showProgress = true;
                this.$router.push({
                    name: 'transactions.index',
                    query: {
                        page,
                        per_page: this.meta.per_page,
                        name: this.name,
                        order_by: this.order_by
                    }
                });
            },
            goToLastPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'transactions.index',
                    query: {
                        page: this.meta.last_page,
                        per_page: this.meta.per_page,
                        name: this.name,
                        order_by: this.order_by
                    }
                });
            },
            goToNextPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'transactions.index',
                    query: {
                        page: this.nextPage,
                        per_page: this.meta.per_page,
                        name: this.name,
                        order_by: this.order_by
                    }
                });
            },
            goToPreviousPage() {
                this.showProgress = true;
                this.$router.push({
                    name: 'transactions.index',
                    query: {
                        page: this.prevPage,
                        per_page: this.meta.per_page,
                        name: this.name,
                        order_by: this.order_by
                    }
                });
            },
            setData(err, { data: items, links, meta }) {
                this.pageNumbers = [];

                if (err) {
                    this.error = err.toString();
                } else {
                    this.items = items;
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
                    name: 'transactions.index',
                    query: {
                        page: 1,
                        per_page: this.meta.per_page,
                        name: this.name,
                        order_by: this.order_by
                    }
                });
            },
            onSearch() {
                this.search(this.itemName, this);
            },
            search: _.debounce((itemName, vm) => {
                axios.get('/api/items/search-for-sales', {
                    params: {
                        name: itemName
                    }
                }).then(res => {
                    vm.items = res.data.data;
                });
            }, 250),
            clear() {
                this.name = '';
                this.amount = '';
                this.order_by = 'desc';
            },
            openSearchModal() {
                $('#search-modal').modal('show');
            },
            openCheckoutModal() {
                if((parseInt(this.cash).toFixed(2) - this.priceSummation()) < 0){
                    alert('Insufficient Funds')
                }else{
                    $('#checkout-modal').modal('show');
                }
            },
            addToCart(item) {
                const found = this.cart.some(el => el.id === item.id);
                if (!found){
                    var cartItem = {
                        id: item.id,
                        name: item.name,
                        amount: item.amount,
                        stocks_available: item.stocks_available,
                        qty: 1
                    }
                    this.cart.push(cartItem);
                    console.log(this.cart);   
                }else {
                    alert('Item already exists in cart');
                }
            },
            priceSummation() {
                var total = 0;
                this.cart.forEach(el => {
                 total += (el.amount * el.qty)
             })
                return total.toFixed(2);
            },
            removeFromCart(item) {
                this.cart.splice(this.cart.findIndex(x => x.id = item.id), 1);
            },
            createNewTransaction() {
                if((parseInt(this.cash).toFixed(2) - this.priceSummation()) < 0){
                    alert('Insufficient Funds');
                } else{
                    this.ifReady = true;
                    var transaction = {
                        total_amount: this.priceSummation(),
                        cart: this.cart
                    }

                    axios.post('/api/transactions', transaction).then(res => {
                        for(let cartItem = 0; cartItem < this.cart.length; cartItem++){
                            let data = {
                                name: this.cart[cartItem].name,
                                amount: this.cart[cartItem].amount,
                                stocks_available: this.cart[cartItem].stocks_available - this.cart[cartItem].qty
                            };

                            axios.patch('/api/items/' + this.cart[cartItem].id, data).then(res => {
                                console.log('Item Update Successful');
                            }).catch(err => {
                                console.log(err);
                            });
                        }

                        $('#checkout-modal').modal('hide');

                        Broadcast.$emit('ToastMessage', {
                            message: 'Transaction Created Successfully'
                        });

                        this.cart = [];
                        this.cash = '';
                        
                        this.$router.go();
                    }).catch(err => {
                        this.ifReady = true;
                        console.log(err);
                    });
                }
            }
        }
    }
</script>

<style>
.clickableText:hover {
    text-decoration: underline;
    cursor: pointer
}

.table > tbody > tr.no-border > td,
.table > tbody > tr.no-border > th {
  border-top: none;
}
</style>
