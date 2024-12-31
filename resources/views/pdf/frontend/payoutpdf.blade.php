<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payout History</title>
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
                    @if (in_array('payout_id_column', $table_column) || $table_column_count == 0)
                        <th align="left">#</th>
                    @endif
                    @if (in_array('date_column', $table_column) || $table_column_count == 0)
                        <th align="left">Date</th>
                    @endif
                    @if (in_array('status_column', $table_column) || $table_column_count == 0)
                        <th align="left">Status</th>
                    @endif
                    @if (in_array('amount_column', $table_column) || $table_column_count == 0)
                        <th align="right">Amount</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($payoutRequestall as $payout)
                    @php
                        $total += $payout->amount;
                    @endphp
                    <tr>
                        @if (in_array('payout_id_column', $table_column) || $table_column_count == 0)
                            <td>{{ @$payout->id }}</td>
                        @endif

                        @if (in_array('date_column', $table_column) || $table_column_count == 0)
                            <td>
                                <p>{{ @$payout->created_at->format('M d, Y') }}</p>
                            </td>
                        @endif
                        @if (in_array('status_column', $table_column) || $table_column_count == 0)
                            <td>
                                <p>{{ $payout->status }}</p>
                            </td>
                        @endif
                        @if (in_array('amount_column', $table_column) || $table_column_count == 0)
                            <td align="right">
                                <p>${{ $payout->amount ? number_format($payout->amount, 2) : 0 }}</p>
                            </td>
                        @endif
                    </tr>
                @endforeach
                @if (in_array('amount_column', $table_column) || $table_column_count == 0)
                    <tr>
                        <td colspan="{{ $table_column_count == 0 ? 3 : $table_column_count - 1 }}" align="center">
                            <strong>Total</strong>
                        </td>
                        <td align="right"><strong>${{ $total ? number_format($total, 2) : '' }}</strong></td>
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
