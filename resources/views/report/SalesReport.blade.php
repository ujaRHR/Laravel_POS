<html>

<head>
    <style>
        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 12px !important;
        }

        .customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .customers tr:hover {
            background-color: #ddd;
        }

        .customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            padding-left: 6px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>

    <div style="text-align: center;">
        <img src="{{'images/logo.png'}}" width="80">
        <h3>INVOICE REPORT</h3>
    </div>

    <table class="customers">
        <thead>
            <tr>
                <th>Report</th>
                <th>Date</th>
                <th>Total</th>
                <th>Discount</th>
                <th>VAT</th>
                <th>Payable</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sales Report</td>
                <td>{{$fromDate}} to {{$toDate}}</td>
                <td>{{$total}}</td>
                <td>{{$discount}}</td>
                <td>{{$vat}}</td>
                <td>{{$payable}} </td>
            </tr>
        </tbody>
    </table>


    <h3>Details</h3>
    <table class="customers">
        <thead>
            <tr>
                <th>Customer</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Total</th>
                <th>Discount</th>
                <th>Vat</th>
                <th>Payable</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item)
            <tr>
                <td>{{$item->customer->name}}</td>
                <td>{{$item->customer->mobile}}</td>
                <td>{{$item->customer->email}}</td>
                <td>{{$item->total }}</td>
                <td>{{$item->discount }}</td>
                <td>{{$item->vat }}</td>
                <td>{{$item->payable }}</td>
                <td>{{$item->created_at }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <br><br>
    <div>
        <span style="font-size: 12px;">This report is auto-generated by iShop's billing system. For any inquiries or
            clarifications regarding this
            invoice, please feel free to reach out to our customer support team. Thank you for choosing our services.
        </span>
    </div>
</body>

</html>