@if (auth()->user()->hasRole('super-admin') || auth()->user()->hasRole('admin'))
    <div class="mb-3">
        <a href="{{ route('dashboard.fundraiser.campaign.campaign.all') }}"
            class="btn btn-sm btn-success  {{ request()->routeIs('dashboard.fundraiser.campaign.campaign.all') ? 'active' : '' }}">Running</a>
        <a href="{{ route('dashboard.fundraiser.campaign.campaign.pending') }}"
            class="btn btn-sm btn-warning {{ request()->routeIs('dashboard.fundraiser.campaign.campaign.pending') ? 'active' : '' }}">Pending</a>
        <a href="{{ route('dashboard.fundraiser.campaign.campaign.completed') }}"
            class="btn btn-sm btn-primary">Completed</a>
        <a href="{{ route('dashboard.fundraiser.campaign.campaign.block') }}" class="btn btn-sm btn-danger">Block</a>
        <a href="{{ route('dashboard.fundraiser.campaign.campaign.stop') }}" class="btn btn-sm btn-secondary">Stop by
            fundraiser</a>
        <a href="{{ route('dashboard.fundraiser.campaign.campaign.reviewed') }}"
            class="btn btn-sm btn-info">Reviewed</a>

    </div>
@elseif (auth()->user()->hasRole('fundraiser'))
    <div class="mb-3">
        <a href="{{ route('fundraiser.post.index') }}" class="btn btn-sm btn-success">Running</a>
        <a href="{{ route('fundraiser.post.campaign.draft') }}" class="btn btn-sm btn-info">Draft</a>
        <a href="{{ route('fundraiser.post.campaign.pending') }}" class="btn btn-sm btn-warning">Pending</a>
        <a href="{{ route('fundraiser.post.campaign.reviewed') }}" class="btn btn-sm btn-info">Reviewed</a>
        <a href="{{ route('fundraiser.post.campaign.completed') }}" class="btn btn-sm btn-primary">Completed</a>
        <a href="{{ route('fundraiser.post.campaign.block') }}" class="btn btn-sm btn-danger">Block</a>
        <a href="{{ route('fundraiser.post.campaign.stop') }}" class="btn btn-sm btn-danger">Stop</a>

    </div>
@endif
