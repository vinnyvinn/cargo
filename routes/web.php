<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Mail\AlertSend;
use Illuminate\Support\Facades\Mail;

Auth::routes();
Route::get('sendmail',function(){
    Mail::to(['email'=>'marvin@wizag.biz'])
        ->cc(['njenga55@gmail.com'])
        ->send(new AlertSend(['subject'=>'this is how its done',
            'body'=>'i told u its simple just call this class everywhere you want']));

    echo "check your mailtrap";
});
Route::get('/quotation/download/{id}', 'QuotationController@downloadPdf');

//transport
Route::group(['middleware' => ['auth']], function (){
    Route::get('/', 'TransportController@index');
    Route::get('/transport', 'TransportController@transport');

    //    po
    Route::get('/generate-po/{quotation_id}', 'PurchaseOrderController@generatePo');
    Route::post('/search-vendor', 'PurchaseOrderController@searchSupplier');
    Route::get('/get-vendor/{id}', 'PurchaseOrderController@getVendor');
    Route::post('/add-purchase-order', 'PurchaseOrderController@addPurchaseOrder');
    Route::get('/view-po/{purchase_order_id}', 'PurchaseOrderController@showPurchaseOrder');
    Route::get('/approve-po/{purchase_order_id}', 'PurchaseOrderController@approvePurchaseOrder');

//contracts
    Route::resource('/contracts', 'ContractController');
    Route::resource('/required-docs', 'TransportDocController');
    Route::resource('/services', 'TransportServiceController');
    Route::resource('/incoterms', 'IncotermController');
    Route::resource('/manage-users', 'ManageUserController');
    Route::get('/generate-quotation', 'CustomerRequestController@generateQuotation');
    Route::post('/search-customer', 'CustomerController@searchCustomer');
    Route::post('/add-services', 'TransportServiceController@addService');
    Route::post('/update-service', 'TransportServiceController@updateService');
    Route::post('/ctm-remarks', 'CtmRemarkController@storeRemarrks');
    Route::post('/quotation-service-delete', 'TransportServiceController@deleteQuotationService');
    Route::post('/delete-doc', 'TransportDocController@deleteDoc');
    Route::get('/quotation/view/{id}', 'QuotationController@viewQuotation');
    Route::get('/quotations', 'QuotationController@allQuotations');
    Route::get('/user-quotations', 'QuotationController@userQuotations');
    Route::get('/get-customer/{id}', 'CustomerController@getCustomer');
    Route::get('/create-role', 'ManageUserController@createRole');
    Route::post('/store-role', 'ManageUserController@storeRole');
    Route::get('/all-roles', 'ManageUserController@roles');
    Route::get('/add-transport/{id}', 'TransportController@addTransport');
    Route::get('/add-cargo', 'CargoController@addCargo');
    Route::post('/store-cargo', 'CargoController@storeCargo');
    Route::post('/store-transport', 'TransportController@storeTransport');
    Route::delete('delete-role/{id}', 'ManageUserController@deleteRole');

//users
    Route::get('/pdas/{status}', 'QuotationController@pdaStatus');
    Route::get('/add-user', 'UserController@addUser');

//Route::get('/', 'HomeController@dashboard');
    Route::resource('/customers', 'CustomerController');
//Route::get('/customer-request/{customer_id}/{customer_type}', 'CustomerRequestController@customerRequest');
    Route::resource('/good-types', 'GoodTypeController');
    Route::resource('/leads', 'LeadController');
    Route::resource('/cargo-types', 'CargoTypeController');
    Route::resource('/tariffs', 'TariffController');
    Route::resource('/departments', 'DepartmentController');
    Route::post('/search-lead', 'LeadController@searchLeads');
    Route::post('/search-dms', 'DmsController@searchDms');
//Route::post('/search-customer', 'CustomerController@ajaxSearch');
    Route::post('//voyage-details', 'CustomerController@voyageDetails');
    Route::post('/update-vessel-details', 'CustomerController@updateVesselDetails');
    Route::post('/cargo-details', 'CustomerController@cargoDetails');
    Route::post('/update-cargo-details', 'CustomerController@updateCargoDetails');
    Route::post('/delete-cargo', 'CustomerController@deleteCargo');
    Route::post('/quotation-service', 'QuotationServiceController@addQuotationService');
//Route::post('/quotation-service-delete', 'QuotationServiceController@deleteQuotationService');
    Route::get('/quotation/{id}', 'QuotationController@showQuotation');
    Route::get('/pdas/{status}', 'QuotationController@pdaStatus');
//Route::get('/quotation/view/{id}', 'QuotationController@viewQuotation');
    Route::get('/quotation/preview/{id}', 'QuotationController@previewQuotation');
    Route::post('/client/quotation/send/', 'QuotationController@sendToCustomer');
    Route::get('/quotation/customer/accepted/{id}', 'QuotationController@customerAccept');
    Route::get('/quotation/customer/declined/{id}', 'QuotationController@customerDecline');
    Route::get('/all-notifications', 'NotificationController@index');
    Route::get('/agency', 'AgencyController@index');
    Route::post('/agency/approve', 'AgencyApprovalController@approve');
    Route::post('/agency/disapprove', 'AgencyApprovalController@revision');
    Route::get('/notifications/{id}', 'NotificationController@show');
    Route::get('/quotation/request/{id}', 'QuotationController@requestQuotation');
//Route::get('/quotation/{id}/pdf', 'QuotationController@pdfQuotation');
//Route::post('/update-service', 'QuotationServiceController@updateService');

//next stage
    Route::get('/quotation/convert/{id}', 'QuotationController@convertCustomer');
    Route::get('/bill-of-lading/{id}', 'BillOfLandingController@edit');
    Route::get('/test/', 'BillOfLandingController@test');
//dms
    Route::get('/dsr', 'DmsController@index');
    Route::get('/report/transport-revenue', 'DmsController@reportTransportRevenue');
    Route::get('/report/tr-download', 'DmsController@downloadReport');
    Route::get('/dms/edit/{id}', 'DmsController@edit');
    Route::get('/generate/laytime/{id}', 'DmsController@generateLayTime');
    Route::post('/dms/store/', 'DmsController@store');
    Route::get('/complete-ctm/{id}', 'DmsController@complete');
    Route::post('/dms/add/sof', 'DmsController@addSof');
    Route::post('/update-dms/', 'DmsController@updateDms');
    Route::post('/vessel/doc/upload/', 'VesselDocsController@upload');
    Route::post('/cargo/image/upload/', 'CargoImageController@upload');
    Route::post('/truck/dsr/', 'TruckController@updates');
    Route::post('/delivery/note/upload/', 'DmsController@deliveryNote');

//stage
    Route::resource('/stages', 'StageController');
    Route::resource('/project-cost', 'PettyCashController');
    Route::get('/approve-project-cost-request/{petty_cash_id}', 'PettyCashController@approve');
    Route::resource('/stage-components', 'StageComponentController');
    Route::post('/service-cost', 'QuotationController@serviceCost');

});