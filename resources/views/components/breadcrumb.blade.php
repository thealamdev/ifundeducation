<section class="breadcrumb_section"
    style="
--bs-breadcrumb-divider: url(
&#34;data:image/svg + xml,
%3Csvgxmlns='http://www.w3.org/2000/svg'width='8'height='8'%3E%3Cpathd='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z'fill='%236c757d'/%3E%3C/svg%3E&#34;
);
">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-sm-6">
                {{ $slot }}
            </div>

            <div class="col-sm-6">
                <div class="text-end">
                    <p> <strong>Roles:</strong>
                        {{-- <span class="fw-semibold">Account Type:</span> --}}
                        @foreach (auth()->user()->roles as $role)
                            <span class="badge bg-success">{{ Str::upper($role->name) }}</span>
                        @endforeach

                        @if (auth()->user()->hasRole('donor'))
                            @if (auth()->user()->hasRole('fundraiser') &&
                                    auth()->user()->hasRole('donor'))
                            @else
                                <a href="{{ route('make.role.fundraiser') }}" class="btn btn-primary"><i
                                        class="fa-regular fa-square-plus"></i> Become a
                                    Fundraiser</a>
                            @endif

                        @endif
                        @if (auth()->user()->hasRole('fundraiser'))
                            @if (auth()->user()->hasRole('fundraiser') &&
                                    auth()->user()->hasRole('donor'))
                            @else
                                <a href="{{ route('make.role.donor') }}" class="btn btn-primary"><i
                                        class="fa-regular fa-square-plus"></i> Become a Donor</a>
                            @endif

                        @endif
                    </p>
                </div>
            </div>
            {{-- <div class="col-sm-4">
                <div class="profile_photo text-end">
                    @if (auth()->user()->photo)
                        <img src="{{ asset('storage/profile_photo/' . auth()->user()->photo) }}"
                            alt="{{ auth()->user()->first_name }}" width="70" class="rounded-circle">
                    @elseif(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" class="rounded-circle"
                            alt="{{ auth()->user()->first_name }}" width="70">
                    @else
                        <img src="{{ Avatar::create(auth()->user()->first_name)->setDimension(70)->setFontSize(16)->toBase64() }}"
                            alt="{{ auth()->user()->first_name }}">
                    @endif
                </div>
            </div> --}}
        </div>
    </div>
</section>
