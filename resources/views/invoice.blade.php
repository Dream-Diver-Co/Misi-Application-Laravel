<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }

    .w-72 {
        width: 73%;
    }

    .w-34 {
        width: 34%;
    }

    .w-33 {
        width: 33%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 150px;
        height: 150px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .text-semi-bold {
        font-weight: 400;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }

    .add-detail {
        margin-bottom: 50px;
    }

    .add-detail {
        margin-bottom: 30px;
    }
</style>

<body>
    @php
        $imagePath = '/vendor/adminlte/dist/img/logo.png';
        $fullImageUrl = url($imagePath);
        //dd($fullImageUrl);
    @endphp

    <div class="add-detail mt-20">
        <div class="w-50 float-left logo ">

            <img src="{{ $fullImageUrl }}" alt="Logo">
            {{-- <img src="http://44.219.8.97:5050/vendor/adminlte/dist/img/logo.png" alt="Logo"> --}}

        </div>
        <div class="w-50 float-left mt-10" align="right">
            <h3 class="m-0 pt-5  w-100">Invoice</h3>
            <p class="m-0 pt-5  w-100">MISI Company Ltd</p>
            <p class="m-0 pt-5  w-100">126 Dutch Road </p>
            <p class="m-0 pt-5  w-100">Netharland </p>
        </div>

        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">Bill To</th>
                <th class="w-50">Bill Info</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p class="m-0 pt-5 text-bold  w-100">Name: <span
                                class="gray-color">{{ $user->name ? $user->name : $user->id }}</span></p>
                        <p class="m-0 pt-5 text-bold  w-100">Address:
                            <span
                                class="gray-color">{{ $patient->residential_address ? $patient->residential_address : '' }}</span>
                        </p>
                        <p class="m-0 pt-5 text-bold w-100">Country: <span
                                class="gray-color">{{ $patient->country ? $patient->country : '' }}</span>
                        </p>
                        <p class="m-0 pt-5 text-bold w-100">Phone <span
                                class="gray-color">{{ $user->phone ? $user->phone : '' }}</span></p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        <p class="m-0 pt-5 text-bold w-100">Ticket Id - <span class="gray-color">#1</span></p>
                        <p class="m-0 pt-5 text-bold w-100">Appointment Id - <span
                                class="gray-color">{{ $intake->appointment_id }}</span>
                        </p>
                        <p class="m-0 pt-5 text-bold w-100">Intake Id - <span
                                class="gray-color">{{ $intake->id }}</span></p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-33">Payment Method</th>
                <th class="w-34">Payment Status</th>
                <th class="w-33">Amount</th>
            </tr>
            <tr align="center">
                <td>{{ $intake->payment_status }}</td>
                <td>{{ $intake->payment_method }}</td>
                <td>{{ $appointment->fee }}</td>
            </tr>
            <tr>
                <td colspan="7">
                    <div class="total-part">
                        <div class="total-left w-72 float-left" align="right">
                            <p>Total</p>
                        </div>
                        <div class="total-right w-15 float-left text-bold" align="right">
                            <p>{{ $appointment->fee }}</p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </td>

            </tr>

            @if ($intake->payment_status == 'Unpaid')
                <tr>
                    <td colspan="7">
                        <div class="total-part">
                            <div class="total-left w-72 float-left" align="right">
                                <p>Total Due</p>
                            </div>
                            <div class="total-right w-15 float-left text-bold" align="right">
                                <p>{{ $appointment->fee }}</p>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                    </td>

                </tr>
            @endif
        </table>
    </div>

</html>
