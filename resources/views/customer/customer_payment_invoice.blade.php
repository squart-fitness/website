<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- <link rel="stylesheet" href="invoice.css"> -->
    <link rel="stylesheet" href={{asset("assets/libraries/css/bootstrap4.5.2.min.css")}}>
    
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    
                        <!-- Invoice Logo-->
                        <div class="clearfix">
                            <div class="float-left mb-3">
                                <img src="logo-light.png" alt="" height="18">
                            </div>
                            <div class="float-right">
                                <h4 class="m-0 d-print-none">Invoice</h4>
                            </div>
                        </div>
                        
                        <!-- Invoice Detail-->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="float-left mt-3">
                                    <h3><b>{{ $pays->gym->userGym->gym_name }}</b></h3>
                                    <h6>{{ $pays->gym->userGym->gym_address }}</h6>
                                    <address>
                                        {{ $pays->gym->userGym->city."    ".$pays->gym->userGym->pincode }}<br>
                                        {{ $pays->gym->state }}<br>
                                        <abbr title="Phone">Phone:</abbr> {{ $pays->gym->userGym->gym_phone }}<br>
                                        <abbr title="Phone">Phone:</abbr> {{ $pays->gym->userGym->gym_phone_second }}
                                    </address>
                                    {{-- <p class="text-muted font-13">Please find below a cost-breakdown for the recent work completed. Please make payment at your earliest convenience, and do not hesitate to contact me with any questions.</p> --}}
                                </div>
    
                            </div><!-- end col -->
                            <div class="col-sm-4 offset-sm-2">
                                <div class="mt-3 float-sm-right">
                                    <p class="font-13"><strong>Billing Date: </strong> &nbsp;&nbsp;&nbsp; {{ date_format($pays->created_at, 'd-M-Y') }}</p>
                                    <p class="font-13"><strong>Billing Status: </strong> <span class="badge badge-success float-right">Paid</span></p>
                                    <p class="font-13"><strong>Billing ID: </strong> <span class="float-right">#123456</span></p>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->
    
                        {{-- <div class="row mt-4">
                            <div class="col-sm-6">
                                <h6>Gym Address</h6>
                                <address>
                                    Lynne K. Higby<br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                </address>
                            </div> <!-- end col-->
    
                            <div class="col-sm-4">
                                <h6>Shipping Address</h6>
                                <address>
                                    Cooper Hobson<br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                </address>
                            </div>
                             <!-- end col-->
    
                            <div class="col-sm-6">
                                <div class="text-sm-right">
                                    <img src="assets/images/barcode.png" alt="barcode-image" class="img-fluid mr-2" />
                                </div>
                            </div> <!-- end col-->
                        </div>    --}} 
                        <!-- end row -->        
    
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mt-4">
                                        <thead>
                                        <tr><th>#</th>
                                            <th>Package</th>
                                            <th>Duration</th>
                                            <th class="text-right">Cost</th>
                                        </tr></thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <b>{{ ucfirst($pays->customer->package) }}</b> <br/>
                                                Package full description
                                            </td>
                                            <td>{{ date_format(date_create($pays->period_start), 'd-m-Y') }} <b>to</b> {{ date_format(date_create($pays->period_end), 'd-m-Y') }}</td>
                                            <td class="text-right">&#8377;{{ $pays->total_amount }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
    
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="clearfix pt-3">
                                    <h6 class="text-muted">Notes:</h6>
                                    <small>
                                        All accounts are to be paid within 7 days from receipt of
                                        invoice. To be paid by cheque or credit card or direct payment
                                        online. If account is not paid within 7 days the credits details
                                        supplied as confirmation of work undertaken will be charged the
                                        agreed quoted fee noted above.
                                    </small>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="float-right mt-3 mt-sm-0">
                                    <p><b>Discount:</b> <span class="float-right">&#8377;{{ $pays->discount }}</span></p>
                                    <p><b>GST (18%):</b> <span class="float-right">&#8377;515.00</span></p>
                                    <p><b>Paid Amount:</b> <span class="float-right">&#8377;{{ $pays->paid_amount }}</span></p>
                                    <p><b>Due:</b> <span class="float-right">&#8377;{{ $pays->due_amount }}</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->
    
                        <div class="d-print-none mt-4">
                            <div class="text-right">
                                <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Print</a>
                            </div>
                        </div>   
                        <!-- end buttons -->
    
                    </div> <!-- end card-body-->
                </div> <!-- end card -->
            </div> <!-- end col-->
        </div>
    </div>
</body>
</html>