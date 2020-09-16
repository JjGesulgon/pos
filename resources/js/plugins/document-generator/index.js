import axios from 'axios';
import moment from 'moment';

export default {
    install: (Vue) => {
        Vue.prototype.$generate = {
            referenceNumber(documentName, options) {
                let total = 0;
                let documentEvent = '';

                async function documentReferenceNumber() {
                    let promiseGetReferenceNumberTotalCount = new Promise((resolve, reject) => {

                        let data = {
                            document_name: documentName,
                            contact_id: options.contact_id
                        };

                        axios.post('/api/documents/get-reference-number-total-count/', data).then(res => {
                            total = res.data.total;
                            resolve();
                        }).catch(err => {
                            console.log(err);
                            reject();
                        });
                    });

                    return promiseGetReferenceNumberTotalCount.then(() => {
                        let referenceNumber = pad(options.contact_id + 1, 8) + "-" + moment().format('YYYY') + moment().format('MM') + moment().format('DD') +  "-" + pad(total + 1, 8);

                        switch(documentName) {

                            case 'transaction':
                                documentEvent = 'NewTransactionReferenceNumberGenerated';
                                break;
                        }

                        Broadcast.$emit(documentEvent, {
                            referenceNumber: referenceNumber
                        });
                    });
                }

                return documentReferenceNumber();
            },

            number(documentName, options) {
                let place = '';
                let id = '';
                let total = 0;
                let documentEvent = '';
                let prefix = '';

                async function waitForDocumentNumber() {
                    let promiseGetNumberTotalCount = new Promise((resolve, reject) => {
                        let data = {
                            document_name: documentName,
                            branch_id: options.branch_id,
                            warehouse_id: options.warehouse_id
                        };

                        axios.post('/api/documents/get-number-total-count/', data).then(res => {
                            total = res.data.total;
                            resolve();
                        }).catch(err => {
                            console.log(err);
                            reject();
                        });
                    });

                    if ('branch_id' in options) {
                        id = options.branch_id;
                        place = 'B';
                    } else {
                        id = options.warehouse_id;
                        place = 'W';
                    }

                    return promiseGetNumberTotalCount.then(() => {
                        let number = moment().format('YYYY') + moment().format('MM') + moment().format('DD') + "-" + place + pad(id, 5) + "-" + pad(total + 1, 8);

                        switch(documentName) {

                            case 'transaction':
                                documentEvent = 'NewTransactionNumberGenerated';
                                prefix = 'T';

                                break;
                        }

                        Broadcast.$emit(documentEvent, {
                            number: prefix + '-' + number
                        });
                    });
                }

                return waitForDocumentNumber();
            }
        };
    },
};

function pad(number, width, z) {
    z = z || '0';
    number = number + '';
    return number.length >= width ? number : new Array(width - number.length + 1).join(z) + number;
}
