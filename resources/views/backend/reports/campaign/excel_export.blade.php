<table>
    <thead>
        <tr>
            <th>
                <strong>Id</strong>
            </th>
            <th>
                <strong>Author</strong>
            </th>
            <th>
                <strong>Campaign</strong>
            </th>
            <th>
                <strong>Category</strong>
            </th>
            <th>
                <strong>Goal</strong>
            </th>
            <th>
                <strong>Status</strong>
            </th>
            <th>
                <strong>End Date</strong>
            </th>
            <th>
                <strong>Created At</strong>
            </th>
            <th>
                <strong>Total Raised</strong>
            </th>
            <th>
                <strong>Stripe Fee</strong>
            </th>
            <th>
                <strong>Platform Fee</strong>
            </th>
            <th>
                <strong>Net Amount</strong>
            </th>
            <th>
                <strong>Stripe Account</strong>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($campaignsDetails as $campaignsDetail)
            <tr>
                <td>{{ $campaignsDetail->id }}</td>
                <td>{{ $campaignsDetail->user->first_name . ' ' . $campaignsDetail->user->last_name . '-' . $campaignsDetail->user->email }}
                </td>
                <td>{{ @$campaignsDetail->title }}</td>
                <td>{{ @$campaignsDetail->fundraisercategory->name }}</td>
                <td>{{ '$' . number_format($campaignsDetail->goal, 2) }}</td>
                <td>{{ $campaignsDetail->status }}</td>
                <td>{{ $campaignsDetail->end_date->format('M d, Y') }}</td>
                <td>{{ $campaignsDetail->created_at->format('M d, Y') }}</td>
                <td>{{ '$' . number_format($campaignsDetail->donates_sum_amount, 2) }}</td>
                <td>{{ '$' . number_format($campaignsDetail->donates_sum_stripe_fee, 2) }}</td>
                <td>{{ '$' . number_format($campaignsDetail->donates_sum_platform_fee, 2) }}</td>
                <td>{{ '$' . number_format($campaignsDetail->donates_sum_net_balance, 2) }}</td>
                <td>{{ @$campaignsDetail->user->stripe_account_id }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
