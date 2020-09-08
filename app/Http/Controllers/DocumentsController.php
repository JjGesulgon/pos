<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    /**
     * Get document reference number count total.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getReferenceNumberTotalCount(Request $request)
    {
        $model = '';

        switch ($request->document_name) {
            case 'purchase-order':
                $model = 'App\PurchaseOrder';
                break;

            case 'transaction':
                $model = 'App\Transaction';
                break;
            
            case 'quotation':
                $model = 'App\Quotation';
                break;
  
            case 'invoice':
                $model = 'App\Invoice';
                break;
        }

        $total = $model::where('contact_id', $request->contact_id)->count();
        
        return response()->json([
            'message' => 'Resource successfully retrieve',
            'total'   => $total
        ], 200);
    }

    /**
     * Get document number count total.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getNumberTotalCount(Request $request)
    {
        $model = '';

        switch ($request->document_name) {

            case 'purchase-order':
                $model = 'App\PurchaseOrder';

                break;

            case 'receive-order':
                $model = 'App\ReceiveOrder';

                break;

            case 'bill':
                $model = 'App\Bill';

                break;

            case 'bill-payment':
                $model = 'App\BillPayment';

                break;

            case 'debit-memorandum':
                $model = 'App\DebitMemorandum';

                break;

            case 'quotation':
                $model = 'App\Quotation';

                break;

            case 'invoice':
                $model = 'App\Invoice';

                break;

            case 'invoice-payment':
                $model = 'App\InvoicePayment';

                break;

            case 'credit-memorandum':
                $model = 'App\CreditMemorandum';

                break;

            case 'transaction':
                $model = 'App\Transaction';

                break;
        }

        $total = $model::count();

        return response()->json([
            'message' => 'Resource successfully retrieve',
            'total'   => $total
        ], 200);
    }
}
