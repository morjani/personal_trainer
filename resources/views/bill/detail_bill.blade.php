
<link rel="stylesheet" href="{{ asset('/assets/invoice/css/style.css') }}">
<style>
    .modal-body {
        padding: 0;
    }
    table {
        border-collapse: collapse;
        border: none; /* This removes all borders from the table */
    }

    td, th {
        border: none; /* This removes borders from table cells */
    }
</style>

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
                            <td style="float:right;">
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
        <div class="cs-invoice_btns cs-hide_print">
            <a href="javascript:void(0);" id="print_bill" class="cs-invoice_btn cs-color1">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                    <path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/>
                    <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/>
                    <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/>
                    <circle cx="392" cy="184" r="24"/>
                </svg>
                <span>Imprimer</span>
            </a>
            <a href="/bill/pdf/{{ $bill->id  }}" target="_blank" type="button" id="download_btn" data-name="{{ strtoupper(stateBill($bill->state)).'-'.$bill->number }}" class="cs-invoice_btn cs-color2">
                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><title>Download</title><path d="M336 176h40a40 40 0 0140 40v208a40 40 0 01-40 40H136a40 40 0 01-40-40V216a40 40 0 0140-40h40" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M176 272l80 80 80-80M256 48v288"/></svg>
                <span>Télécharger</span>
            </a>
        </div>
    </div>

@endif


