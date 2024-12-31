<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Donation List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        p {
            padding: 0;
            margin: 0;
            font-size: 14px;
        }

        @page {
            header: page-header;
            footer: page-footer;
            margin-top: 130px;
        }

        .page-break {
            page-break-after: always;
        }

        body {
            font-family: sans-serif;
        }
    </style>
</head>

<body>
    @php
        $table_column_count = count($table_column);
    @endphp
    <main>
        <htmlpageheader name="page-header">
            <div style="text-align: center">
                <img width="150" src="{{ asset('frontend/images/theme_options/' . $themeOption->site_logo) }}"
                    alt="">
                <p>{{ @$themeOption->footer_about_title }}</p>
                <p>{{ @$themeOption->header_email }}</p>
            </div>
        </htmlpageheader>
        <table style="width: 100%" border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr height="50">
                    @if (in_array('campaign_id', $table_column) || $table_column_count == 0)
                        <th align="left">#</th>
                    @endif
                    @if (in_array('campaign_title', $table_column) || $table_column_count == 0)
                        <th align="left">Campaign</th>
                    @endif
                    @if (in_array('donor', $table_column) || $table_column_count == 0)
                        <th align="left">Donor</th>
                    @endif
                    @if (in_array('date', $table_column) || $table_column_count == 0)
                        <th align="left">Date</th>
                    @endif
                    @if (in_array('stripe_fee', $table_column) || $table_column_count == 0)
                        <th align="right">Payment Fee</th>
                    @endif
                    @if (in_array('amount', $table_column) || $table_column_count == 0)
                        <th align="right">Amount</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $total_stripe_fee = 0;
                @endphp
                @foreach ($all_donars as $all_donar)
                    @php
                        $total += $all_donar->net_balance;
                        $total_stripe_fee += $all_donar->stripe_fee;
                    @endphp
                    <tr>
                        @if (in_array('campaign_id', $table_column) || $table_column_count == 0)
                            <td>{{ @$all_donar->id }}</td>
                        @endif
                        @if (in_array('campaign_title', $table_column) || $table_column_count == 0)
                            <td>
                                <p>{{ @$all_donar->title }}</p>
                            </td>
                        @endif
                        @if (in_array('donor', $table_column) || $table_column_count == 0)
                            <td>
                                <p>{{ $all_donar->display_publicly == 'no' ? 'Guest' : @$all_donar->donar_name }}</p>
                            </td>
                        @endif
                        @if (in_array('date', $table_column) || $table_column_count == 0)
                            <td>
                                <p>{{ @$all_donar->created_at->format('M d, Y') }}</p>
                            </td>
                        @endif
                        @if (in_array('stripe_fee', $table_column) || $table_column_count == 0)
                            <td align="right">
                                <p>${{ $all_donar->stripe_fee ? number_format($all_donar->stripe_fee, 2) : '' }}</p>
                            </td>
                        @endif
                        @if (in_array('amount', $table_column) || $table_column_count == 0)
                            <td align="right">
                                <p>${{ $all_donar->net_balance ? number_format($all_donar->net_balance, 2) : '' }}</p>
                            </td>
                        @endif
                    </tr>
                @endforeach
                @if (in_array('amount', $table_column) || in_array('stripe_fee', $table_column) || $table_column_count == 0)
                    <tr>
                        <td colspan="{{ $table_column_count == 0 ? 4 : (in_array('stripe_fee', $table_column) && in_array('amount', $table_column) ? $table_column_count - 2 : $table_column_count - 1) }}"
                            align="center">
                            <strong>Total</strong>
                        </td>
                        @if (in_array('stripe_fee', $table_column) || $table_column_count == 0)
                            <td align="right">
                                <strong>${{ $total_stripe_fee ? number_format($total_stripe_fee, 2) : '' }}</strong>
                            </td>
                        @endif
                        @if (in_array('amount', $table_column) || $table_column_count == 0)
                            <td align="right"><strong>${{ $total ? number_format($total, 2) : '' }}</strong></td>
                        @endif

                    </tr>
                @endif

            </tbody>
        </table>
    </main>
    <htmlpagefooter name="page-footer">
        <div style="text-align: center">
            <p>{{ @$themeOption->copyright_text }}</p>
        </div>
    </htmlpagefooter>
</body>

</html>
