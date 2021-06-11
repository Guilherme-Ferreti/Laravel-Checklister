<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <ul class="c-sidebar-nav">
        @if (auth()->user()->is_admin)
            <li class="c-sidebar-nav-title">{{ __('Manage checklists') }}</li>

            @foreach (\App\Models\ChecklistGroup::with('checklists')->get() as $group)
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                    
                    <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="{{ route('admin.checklist_groups.edit', $group) }}">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-folder-open') }}"></use>
                        </svg>{{ $group->name }}
                    </a>

                    <ul class="c-sidebar-nav-dropdown-items">
                        @foreach ($group->checklists as $checklist)
                        <li class="c-sidebar-nav-item">
                            <a class="c-sidebar-nav-link" href="{{ route('admin.checklist_groups.checklists.edit', [$group, $checklist]) }}" style="padding: .5rem .5rem .5rem 76px;">
                                <svg class="c-sidebar-nav-icon">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list') }}"></use>
                                </svg>
                                {{ $checklist->name }}
                            </a>
                        </li>
                        @endforeach
                        <li class="c-sidebar-nav-item">
                            <a class="c-sidebar-nav-link" href="{{ route('admin.checklist_groups.checklists.create', $group) }}">
                                <svg class="c-sidebar-nav-icon">
                                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-note-add') }}"></use>
                                </svg>
                                {{ __('New checklist') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endforeach

            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('admin.checklist_groups.create') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-library-add') }}"></use>
                    </svg>
                    {{ __('New checklist group') }}
                </a>
            </li>

            <li class="c-sidebar-nav-title">{{ __('Pages') }}</li>

            @foreach (\App\Models\Page::all() as $page)
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                    <a class="c-sidebar-nav-link" href="{{ route('admin.pages.edit', $page) }}">
                        <svg class="c-sidebar-nav-icon">
                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-puzzle') }}"></use>
                        </svg>{{ $page->title }}
                    </a>
                </li>
            @endforeach

            <li class="c-sidebar-nav-title">{{ __('Manage Data') }}</li>

            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user') }}"></use>
                    </svg>{{ __('Users') }}
                </a>
            </li>

        @else
            <li class="c-sidebar-nav-title">{{ __('Checklists') }}</li>
            @foreach (\App\Models\ChecklistGroup::with(['checklists' => function ($query) {
                $query->whereNull('user_id');
            }])->get() as $group)
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
                    <svg class="c-sidebar-nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-folder-open') }}"></use>
                    </svg>{{ $group->name }}
                </a>

                <ul class="c-sidebar-nav-dropdown-items">
                    @foreach ($group->checklists as $checklist)
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('users.checklists.show', $checklist) }}" style="padding: .5rem .5rem .5rem 76px;">
                            <svg class="c-sidebar-nav-icon">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list') }}"></use>
                            </svg>
                            {{ $checklist->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        @endif
    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>