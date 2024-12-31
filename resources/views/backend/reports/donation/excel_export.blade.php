<table>
    <thead>
        <tr>
            <th><strong>Id</strong></th>
            <th><strong>Fundraiser</strong></th>
            <th><strong>Campaign</strong></th>
            <th><strong>Status</strong></th>
            <th><strong>Created At</strong></th>
            <th><strong>Total Raised</strong></th>
            <th><strong>Stripe Fee</strong></th>
            <th><strong>Platform Fee</strong></th>
            <th><strong>Net Amount</strong></th>
            <th><strong>Transaction Id</strong></th>
            <th><strong>Currency</strong></th>
            <th><strong>Donor name</strong></th>
            <th><strong>Donor email</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($donations as $donation)
            <tr>
                <td>{{ $donation->id }}</td>
                <td>{{ $donation->campaign->user->first_name . ' ' . $donation->campaign->user->last_name . '-' . $donation->campaign->user->email }}
                </td>
                <td>{{ $donation->campaign->title ?? '' }}</td>
                <td>{{ $donation->status ?? '' }}</td>
                <td>{{ $donation->created_at->format('M d, Y H:i:s') }}</td>
                <td>{{ '$' . number_format($donation->amount, 2) }}</td>
                <td>{{ '$' . number_format($donation->stripe_fee, 2) }}</td>
                <td>{{ '$' . number_format($donation->platform_fee, 2) }}</td>
                <td>{{ '$' . number_format($donation->net_balance, 2) }}</td>
                <td>{{ $donation->balance_transaction_id ?? '' }}</td>
                <td>{{ $donation->currency ?? '' }}</td>
                <td>{{ $donation->donar_name ?? 'Guest' }}</td>
                <td>{{ $donation->donar_email ?? '--' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
