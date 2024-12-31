<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Campaigns List</title>
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
                    @if (in_array('campaign_id_column', $table_column) || $table_column_count == 0)
                        <th align="left">#</th>
                    @endif
                    @if (in_array('campaign_title_column', $table_column) || $table_column_count == 0)
                        <th align="left">Campaign</th>
                    @endif
                    @if (in_array('start_date_column', $table_column) || $table_column_count == 0)
                        <th align="left">Start Date</th>
                    @endif
                    @if (in_array('end_date_column', $table_column) || $table_column_count == 0)
                        <th align="left">End Date</th>
                    @endif
                    @if (in_array('status_column', $table_column) || $table_column_count == 0)
                        <th align="left">Status</th>
                    @endif
                    @if (in_array('target_column', $table_column) || $table_column_count == 0)
                        <th align="right">Target</th>
                    @endif
                    @if (in_array('raised_column', $table_column) || $table_column_count == 0)
                        <th align="right">Raised</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $totalTarget = 0;
                    $totalRaised = 0;
                @endphp
                @foreach ($campaigns as $campaign)
                    @php
                        $totalTarget += $campaign->goal;
                        $totalRaised += $campaign->donates_sum_net_balance;
                    @endphp
                    <tr>
                        @if (in_array('campaign_id_column', $table_column) || $table_column_count == 0)
                            <td>{{ @$campaign->id }}</td>
                        @endif
                        @if (in_array('campaign_title_column', $table_column) || $table_column_count == 0)
                            <td>
                                <p>{{ @$campaign->title }}</p>
                            </td>
                        @endif
                        @if (in_array('start_date_column', $table_column) || $table_column_count == 0)
                            <td>
                                <p>{{ @$campaign->created_at->format('M d, Y') }}</p>
                            </td>
                        @endif
                        @if (in_array('end_date_column', $table_column) || $table_column_count == 0)
                            <td>
                                <p>{{ @$campaign->end_date->format('M d, Y') }}</p>
                            </td>
                        @endif
                        @if (in_array('status_column', $table_column) || $table_column_count == 0)
                            <td>
                                <p>{{ @$campaign->status }}</p>
                            </td>
                        @endif
                        @if (in_array('target_column', $table_column) || $table_column_count == 0)
                            <td align="right">
                                <p>${{ $campaign->goal ? number_format($campaign->goal, 2) : 0 }}</p>
                            </td>
                        @endif
                        @if (in_array('raised_column', $table_column) || $table_column_count == 0)
                            <td align="right">
                                <p>${{ $campaign->donates_sum_net_balance ? number_format($campaign->donates_sum_net_balance, 2) : 0 }}
                                </p>
                            </td>
                        @endif
                    </tr>
                @endforeach
                @if (in_array('target_column', $table_column) || in_array('raised_column', $table_column) || $table_column_count == 0)
                    <tr>
                        <td colspan="{{ $table_column_count == 0 ? 5 : (in_array('target_column', $table_column) && in_array('raised_column', $table_column) ? $table_column_count - 2 : $table_column_count - 1) }}"
                            align="center">
                            <strong>Total</strong>
                        </td>
                        @if (in_array('target_column', $table_column) || $table_column_count == 0)
                            <td align="right">
                                <strong>${{ $totalTarget ? number_format($totalTarget, 2) : 0 }}</strong>
                            </td>
                        @endif
                        @if (in_array('raised_column', $table_column) || $table_column_count == 0)
                            <td align="right">
                                <strong>${{ $totalRaised ? number_format($totalRaised, 2) : 0 }}</strong>
                            </td>
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
