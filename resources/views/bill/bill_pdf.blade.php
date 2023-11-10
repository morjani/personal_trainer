<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facture</title>
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/assets/invoice/css/style.css') }}">
</head>
<style>
    table {
        border-collapse: collapse;
        border: none; /* This removes all borders from the table */
    }

    td, th {
        border: none; /* This removes borders from table cells */
    }
</style>
<body>


@if($bill)

    <div class="cs-container" id="detail_bills">
        <div class="cs-invoice cs-style1">
            <div class="cs-invoice_in" id="download_section" style="border-collapse: separate;
    border-spacing: 1em 2px;">

                <div class="row">
                    <table>
                        <tr>
                            <td>
                                <img src="{{ getLogoBill() }}" class="logo" style="width: 190px;">
                            </td>
                            <td>
                                <h2 class="document-type display-5" style="color:#9c782c">{{ stateBill($bill->state)}}</h2>

                                @if($bill->state==1)
                                <p class="text-right"><strong>N°{{ $bill->number }}</strong></p>
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-top: -14px">
                                    <?= getMetaByName('bill_information_verychic') ?>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div style="margin-top: -36px">
                                    <b class="cs-primary_color" style="color: black">Client:</b>
                                    @if($customer)
                                        <p>
                                            {{ $customer->last_name }}
                                            <br>

                                            @if($city)
                                                {{ $city->name }} <br>
                                            @endif

                                            @if($customer->ice)
                                                ICE : {{ $customer->ice }} <br>
                                            @endif

                                            @if($customer->email)
                                                Email : {{ $customer->email }} <br>
                                            @endif

                                            @if($customer->phone)
                                                Téléphone : {{ $customer->phone }} <br>
                                            @endif
                                        </p>
                                    @endif
                                </div>

                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:right;">
                                <b class="cs-primary_color" style="color: black">
                                    Fès le {{ date('d-m-Y') }}
                                </b>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="cs-table cs-style1">
                    <div class="cs-round_border">
                        <div class="cs-table_responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th class="cs-width_6 cs-bold cs-primary_color cs-focus_bg">Description</th>
                                    <th class="cs-width_2 cs-bold cs-primary_color cs-focus_bg">Unité</th>
                                    <th class="cs-width_1 cs-bold cs-primary_color cs-focus_bg">Quantité</th>
                                    <th class="cs-width_2 cs-bold cs-primary_color cs-focus_bg cs-text_right">Total</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($details as $detail)

                                    <tr>
                                        <td class="cs-width_6">
                                            <p class="font-size-13 mb-0" style="color: black">
                                                {{ $detail->service.' '.$date_event }}
                                            </p>
                                            <p class="text-muted mb-0 font-size-12">
                                                {{ $detail->description }}
                                            </p>

                                        </td>
                                        <td class="cs-width_2">{{ $detail->price }}</td>
                                        <td class="cs-width_1">{{ $detail->quantity }}</td>
                                        <td class="cs-width_2 cs-text_right">{{ $detail->total }}</td>
                                    </tr>

                                @endforeach

                                <tr class="cs-border_left">
                                    <td rowspan="2" colspan="2">
                                        @if($bill->additional_information)
                                            <p class="cs-mb0"><b class="cs-primary_color text-black" style="color: black">
                                                    Informations Complémentaires:</b></p>
                                            <p class="cs-m0">{{ $bill->additional_information }}</p>
                                        @endif
                                    </td>
                                    <td class="cs-width_3 cs-bold cs-primary_color cs-focus_bg">SOUS TOTAL</td>
                                    <td class="cs-width_3 cs-bold cs-focus_bg cs-primary_color cs-text_right">
                                        {{ $bill->total_ht }}
                                    </td>
                                </tr>
                                <tr class="cs-border_left">
                                    <td class="cs-width_3 cs-bold cs-primary_color cs-focus_bg">TVA</td>
                                    <td class="cs-width_3 cs-bold cs-focus_bg cs-primary_color cs-text_right">20%</td>
                                </tr>

                                @foreach($other_details as $othder_detail)

                                    <tr>
                                        <td class="cs-width_6">
                                            <p class="text-black font-size-15 mb-0">
                                                {{ $othder_detail->service }}
                                            </p>
                                            <p class="text-muted mb-0 font-size-12">
                                                {{ $othder_detail->description }}
                                            </p>
                                        </td>
                                        <td class="cs-width_2">{{ $othder_detail->price }}</td>
                                        <td class="cs-width_1">{{ $othder_detail->quantity }}</td>
                                        <td class="cs-width_2 cs-text_right">{{ $othder_detail->total }}</td>
                                    </tr>

                                @endforeach

                                <tr class="cs-border_left">
                                    <td></td>
                                    <td></td>
                                    <td class="cs-width_3 cs-bold cs-primary_color cs-focus_bg">TOTAL TTC</td>
                                    <td class="cs-width_3 cs-bold cs-focus_bg cs-primary_color cs-text_right">
                                        {{ $bill->total_ttc }}
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="cs-note">
                    <div class="cs-note_right">
                        <p class="cs-mb0"><b class="cs-primary_color cs-bold">Note:</b></p>
                        <p class="cs- font-size-12">CONDITIONS ET MODALITÉS DE PAIEMENT<br> A payer par virement bancaire<br>
                            CREDIT AGRICOLE DU MAROC<br>225 270 0015926216651011104</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endif


</body>
</html>
