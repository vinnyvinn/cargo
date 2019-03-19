@extends('layouts.main')
@section('content')
    <div class="row page-titles m-b-0">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
        <div>
            <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="card card-body printableArea">
                <h3 class="text-center">Proposal</h3>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <address>
                                <img src="{{ asset('images/logo.png') }}" alt="">
                                <h4>Express Shipping & Logistics (EA) Limited</h4>
                                <h4>Cannon Towers <br>
                                    6th Floor, Moi Avenue Mombasa - Kenya <br>
                                    Email :agency@esl-eastafrica.com or ops@esl-eastafrica.com <br>
                                    Web: www.esl-eastafrica.com</h4>
                            </address>
                        </div>
                        <div class="pull-right">
                            <h4><b>Customer Details</b></h4>
                            <h4 class="inputcurrency">Choose Currency <button onclick="currencyChangeUSD()" class="inputcurrency btn btn-sm btn-info">USD</button>
                                <button onclick="currencyChangeKES()" class="inputcurrency btn btn-sm btn-warning">KES</button></h4>
                            <div id="add_customer" class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="customer"><h4>Add Customer</h4></label>
                                        <input type="text" id="customer" class="form-control" placeholder="Search customer">
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="display"></div>
                                </div>
                            </div>
                            <address id="client_details">
                                <br>
                                <p><b>Date : </b> {{ \Carbon\Carbon::now()->format('d-M-y') }}</p>
                            </address>
                        </div>
                    </div>
                   @include('partials.cargo-details')
                    <div class="col-md-12">
                        <div class="table-responsive m-t-40" style="clear: both;">
                            @include('partials.add-service')
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right m-t-30 text-right">
                            <div class="col-sm-12">
                                <h3 id="total_amount"><b id="iccurenyc">Total :</b> 0</h3>
                            </div>
                            <div class="col-sm-12">
                                <button onclick="storeServiceData()" class="btn btn-block btn-primary gen-quote">Generate</button>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var search_item = $('#customer');
        var display_search = $('#display');
        var data = {
            'currency' : '',
            'cargo_id' : '{{$cargo->id}}',
            'inputCur' : '',
            'exrate' : '{{ $exrate }}',
            'DCLink':'',
            'type':'{{$type->name}}',
            'services':{}
        }
        
        search_item.on('keyup', function () {

            if(search_item.val() == "") {
                display_search.html("")
            }
            else {
                axios.post('/search-customer', {'search_item' : search_item.val()})
                    .then( function (response) {
                        display_search.empty().append(response.data.output);
                    })
                    .catch( function (response) {
                        console.log(response.data);
                    });
            }
        });

        function addService() {

            console.log(this.data.inputCur, this.data.currency);
            var service_selling = 0;
            var  checkit = 0;
            var selected = document.getElementById("service");
            var sTax = document.getElementById("tax");

            if($('#service').val() === "" || $('#service').val() === null){
                alert('Select one service');
                return true;
            }

            if($('#tax').val() === "" || $('#tax').val() === null){
                alert('Select Tax');
                return true;
            }

            var getSelectedService = JSON.parse(selected.options[selected.selectedIndex].value);

            var selectedTax = JSON.parse(sTax.options[sTax.selectedIndex].value);

            var service_units = $('#service_units').val();
            var service_sp = $('#selling_price').val();

            if(service_sp === "" || service_sp === null){
                alert('Selling price cannot be empty');
                return true;
            }

            service_selling= $('#selling_price').val();

            checkit = this.data.inputCur == 'USD' ? (parseFloat(service_selling) * parseFloat(this.data.exrate)) : service_selling;

            if(service_units === "" || service_units === null){
                alert('Enter value');
                return true;
            }

            else if(this.data.inputCur !== this.data.currency){
                alert('The client Currency should be the same as input Currency. Select client ' + this.data.inputCur + ' Currency Account');
                window.location.reload();
            }
            else if (this.data.DCLink === ''){
                alert('No customer added');
                return true;
            }

            else if (this.data.inputCur === ''){
                alert('Select Currency');
                return true;
            }
            else if (service_selling === "" || service_selling === null){
                alert('Enter Selling');
                return true;
            }

            else if(parseFloat(checkit) < parseFloat(getSelectedService.rate)){
                console.log(checkit);
                console.log(parseFloat(getSelectedService.rate));
                alert('Selling Price Cannot Be Below Buying Price');
                return true;
            }
            else {

//                addServiceToData({
//                    'id':((Object.keys(this.data.services).length) + 1),
//                    'service_id':getSelectedService.id,
//                    'rate':getSelectedService.rate,
//                    'selling_price':service_sp,
//                    'tax_code' : selectedTax.Code,
//                    'tax_description' : selectedTax.Description,
//                    'tax_id' : selectedTax.idTaxRate,
//                    'tax':((selectedTax.TaxRate * (service_sp * service_units)) / 100),
//                    'type':getSelectedService.type,
//                    'unit':getSelectedService.unit,
//                    'total_units':service_units,
//                    'name':getSelectedService.name,
//                    'total':(((selectedTax.TaxRate * (service_sp * service_units)) / 100) + (service_sp * service_units))
//                })

                if(this.data.inputCur == 'KES'){
                    var getrate = (parseInt(getSelectedService.fixed) === 0 ? getSelectedService.rate : (parseFloat(getSelectedService.rate) * parseFloat(this.data.exrate)));
                    addServiceToData({
                        'id':((Object.keys(this.data.services).length) + 1),
                        'service_id':getSelectedService.id,
                        'rate': this.data.currency == 'USD' ? (getrate / this.data.exrate) : getrate,
                        'stock_link':getSelectedService.StockLink,
                        'selling_price': this.data.currency == 'USD' ? (service_selling / this.data.exrate) : service_selling,
                        'tax_code' : selectedTax.Code,
                        'tax_description' : selectedTax.Description,
                        'tax_id' : selectedTax.idTaxRate,
                        'tax': this.data.currency == 'USD' ? (parseFloat(((selectedTax.TaxRate * (service_selling * service_units)) / 100)) / parseFloat(this.data.exrate)) : parseFloat(((selectedTax.TaxRate * (service_selling * service_units)) / 100)),
                        'type':getSelectedService.type,
                        'unit':getSelectedService.unit,
                        'total_units':service_units,
                        'name':getSelectedService.name,
                        'total': this.data.currency == 'USD' ? (parseFloat((((selectedTax.TaxRate * (service_selling * service_units)) / 100) +
                            (service_selling * service_units))) / parseFloat(this.data.exrate)) : parseFloat((((selectedTax.TaxRate * (service_selling * service_units)) / 100) +
                            (service_selling * service_units)))
                    })
                }

                else {
                    addServiceToData({

                        'id':((Object.keys(this.data.services).length) + 1),
                        'service_id':getSelectedService.id,
                        'rate': (parseInt(getSelectedService.fixed) === 0 ? (getSelectedService.rate / this.data.exrate) :(getSelectedService.rate)),
                        'stock_link':getSelectedService.StockLink,
                        'selling_price': this.data.currency == 'KES' ? (service_selling * this.data.exrate) : service_selling,
                        'tax_code' : selectedTax.Code,
                        'tax_description' : selectedTax.Description,
                        'tax_id' : selectedTax.idTaxRate,
                        'tax': this.data.currency == 'KES' ? (parseFloat(((selectedTax.TaxRate * (service_selling * service_units)) / 100)) * parseFloat(this.data.exrate)) : parseFloat(((selectedTax.TaxRate * (service_selling * service_units)) / 100)),
                        'type':getSelectedService.type,
                        'unit':getSelectedService.unit,
                        'total_units':service_units,
                        'name':getSelectedService.name,
                        'total': this.data.currency == 'KES' ? (parseFloat((((selectedTax.TaxRate * (service_selling * service_units)) / 100) +
                            (service_selling * service_units))) * parseFloat(this.data.exrate)) : parseFloat((((selectedTax.TaxRate * (service_selling * service_units)) / 100) +
                            (service_selling * service_units)))
                    })
                }

                resetForm();
            };
        }

        function resetForm() {
            $('#service').val(1).trigger('change.select2');
            $('#tax').val(1).trigger('change.select2');
            $('#service_units').val('');
            $('#selling_price').val('').removeAttr('readonly');
        }

        function storeServiceData() {
            $('.gen-quote').attr('disabled',true).text('Please Wait');
            if (Object.keys(this.data.services).length > 0 && this.data.DCLink !== ''){
                axios.post('{{url('/add-services')}}', this.data)
                    .then( function (response) {
                        window.location.href = '{{ url('/quotation') }}/' + response.data.quotation_id;
                    })
                    .catch( function (response) {
                        console.log(response.data);
                    });
            }
            else {
                var errorMsg = '';
                if (Object.keys(this.data.services).length < 1){
                    errorMsg = errorMsg + '1. No service added \n';
                }

                if (this.data.DCLink === ''){
                    errorMsg += '2. No customer added'
                }
                console.log(errorMsg);
                alert(errorMsg);
            }
        }

        function deleteSerive(service) {
            service_id = service.parentNode.parentNode;
            console.log(this.data);
            delete this.data.services[service_id.id];
            service_id.parentNode.removeChild(service_id);
            $('#total_amount').empty().append('<b>Total ' + this.data.currency + ' :</b>' + ' ' + getTotal().toFixed(2))

        }

        function getTotal() {
            if (Object.keys(this.data.services).length > 0){
                return Object.values(this.data.services).reduce(function (a,b) {
                    return (a + b.total);
                },0);
            }
            else{
                return 0;
            }
        }

        function addServiceToData(service) {
            $('#service_table').append('<tr id="' + service.id + '">' +
                '<td>' + service.name + '</td>' +
                '<td class="text-right">' + Number(service.total_units).toFixed(2) + '</td>' +
                '<td class="text-right">' + Number(service.selling_price).toFixed(2) + '</td>' +
                '<td class="text-right">' + Number(service.tax).toFixed(2) + '</td>' +
                '<td class="text-right">' + Number(service.total).toFixed(2)+ '</td>' +
                '<td class="text-right"><button onclick="deleteSerive(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>' +
                '</tr>');
            this.data.services[service.id] = service;
            console.log(service);
            notifyMe(service.name + ' added | Expected profit : ' + this.data.currency + ' ' + (parseFloat(service.total) - (parseFloat(service.tax) + (parseFloat(service.rate) * parseFloat(service.total_units)))).toFixed(2));
            $('#total_amount').empty().append('<b>TOTAL : '+ this.data.currency + '</b> ' + ' ' + getTotal().toFixed(2))

        }

        function notifyMe(text) {
            $('#notification').empty().append(text);
        }

        function fillData(dclink) {
            axios.get('{{ url('/get-customer') }}/' + dclink)
                .then( function (response) {
                    var customer = response.data.customer;

                    $('#add_customer').hide();
                    $('#client_details').empty().append(
                    '<div class="col-sm-12"><h4><b>To</b></h4>'+
                    '<h4 id="client-name"> Name : ' + customer.Name + '</h4>'+
                        '<h4 id="contact-person">Contact Person : ' + customer.Contact_Person + '</h4>'+
                        '<h4 id="contact-phone">Phone : ' + customer.Telephone + '</h4>'+
                        '<h4 id="contact-email">Email : ' + customer.EMail + '</h4></div>'+
                        '<h4 id="contact-currency">Currency : ' + (customer.iCurrencyID == 1 ? 'USD' : 'KES') + '</h4></div>'
                    );
                    this.data.currency = (customer.iCurrencyID == 1 ? 'USD' : 'KES');


                    if(this.data.inputCur !== '' && this.data.inputCur !== this.data.currency){
                        alert('The client Currency should be the same as input Currency. Select client ' + this.data.inputCur + ' Currency Account');
                        window.location.reload();
                    }

                    $('#currency').empty().append('CURRENCY ' + this.data.currency);
                    $('#iccurenyc').empty().append(customer.iCurrencyID == 1 ? 'TOTAL USD' : 'TOTAL KES');
                })
                .catch( function (response) {
                   console.log(response.data);
                });

            this.data.DCLink = dclink;
            display_search.empty();
        }

        function currencyChangeKES() {
            this.data.inputCur = 'KES';
            $('.inputcurrency').hide();
        }

        function checkType(selected) {
            $('#selling_price').removeAttr('readonly');
            if($('#service').val() === "" || $('#service').val() === null){
                return true;
            }
            else if(this.data.currency === ''){
                alert('Select Customer')
                resetForm();
            }
            else{
                var getSelected = JSON.parse(selected.options[selected.selectedIndex].value);

                    if(parseInt(getSelected.fixed) == 1){
                        $('#selling_price').val(this.data.currency == 'USD' ? getSelected.rate : (parseFloat(getSelected.rate) * parseFloat(this.data.exrate))).attr('readonly','readonly');
                    }
            }
        }

        function currencyChangeUSD() {
            this.data.inputCur = 'USD';
            $('.inputcurrency').hide();
        }
    </script>
@endsection
