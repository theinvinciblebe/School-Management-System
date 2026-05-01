@extends('layout.main')
@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inbox</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Inbox</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-1"></div>

            <div class="col-md-10">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Inbox</h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control search-input" placeholder="Search Mail">
                                <div class="input-group-append">
                                    <div class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-0">
                        <div class="mailbox-controls">
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle-top">
                                <i class="far fa-square"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm btn-delete">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-reply"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <div class="float-right">
                                1-50/200
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Messages Table -->
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                @foreach( $notifications as $notification)
                                    @php
                                        $redirectUrl = match (true) {
                                            in_array($notification->type, ['Purchase Request', 'Purchase Approval', 'Purchase Rejected']) => route('purchase_req.index'),
                                            in_array($notification->type, ['Fee Request', 'Fee Approval', 'Fee Rejected']) => route('fee_receipt.index'),
                                            $notification->type === 'Admission' => route('admissions.list'),
                                            default => '#',
                                        };
                                    @endphp
                                    <tr class="notification-row {{ $notification->is_read ? '' : 'font-weight-bold bg-light' }}"
                                        data-id="{{ $notification->id }}"
                                        data-read="{{ $notification->is_read ? 'true' : 'false' }}"
                                        data-href="{{ $redirectUrl }}">

                                        <td>
                                            <div class="icheck-primary">
                                                <input type="checkbox" class="mail-check" id="check{{ $notification->id }}" data-id="{{ $notification->id }}">
                                                <label for="check{{ $notification->id }}"></label>
                                            </div>
                                        </td>

                                        <td class="mailbox-star">
                                            <a href="#"><i class="fas fa-star text-warning"></i></a>
                                        </td>
                                        <td class="mailbox-name">
                                            <a href="#">{{ $notification->user->name ?? 'Guest' }}</a>
                                        </td>
                                        <td class="mailbox-subject">
                                            <b>{{ $notification->type }}</b> -
                                            <a href="#">
                                                {{ Str::limit($notification->message, 65, '...') }}
                                            </a>
                                        </td>
                                        <td class="mailbox-date">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination -->
{{--                            {{ $notifications->links() }}--}}
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer p-0">
                        <div class="mailbox-controls">
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle-bottom">
                                <i class="far fa-square"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm btn-delete">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-reply"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-share"></i>
                                </button>
                            </div>
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <div class="float-right">
                                1-50/200
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-sm">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JS Scripts -->
    <script>
        document.querySelectorAll(".notification-row").forEach(row => {
            row.addEventListener("click", function (e) {
                // if (e.target.closest('input') || e.target.closest('label') || e.target.closest('a')) {
                //     return; // ignore checkbox, label, or link clicks
                // }

                const href = this.getAttribute("data-href");
                const notificationId = this.getAttribute("data-id");
                const isRead = this.getAttribute("data-read");

                if (isRead === "false") {
                    fetch(`/notifications/read/${notificationId}`, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        }
                    }).then(response => response.json())
                        .then(data => {
                            this.setAttribute("data-read", "true");
                            this.classList.remove("font-weight-bold", "bg-light");
                        });
                }

                if (href && href !== "#") {
                    window.location.href = href;
                }
            });
        });
    </script>

    @push('scripts')
        <script>
            $(function () {
                let allChecked = false;

                function toggleAllCheckboxes(state) {
                    $('.mail-check').prop('checked', state);
                    const iconClass = state ? 'fa-check-square' : 'fa-square';
                    $('.checkbox-toggle-top i, .checkbox-toggle-bottom i')
                        .removeClass('fa-square fa-check-square')
                        .addClass(iconClass);
                }

                $('.checkbox-toggle-top, .checkbox-toggle-bottom').click(function () {
                    allChecked = !allChecked;
                    toggleAllCheckboxes(allChecked);
                });

                $('.mail-check').on('change', function () {
                    const total = $('.mail-check').length;
                    const checked = $('.mail-check:checked').length;
                    allChecked = total === checked;
                    toggleAllCheckboxes(allChecked);
                });

                $('.btn-delete').click(function () {
                    const ids = $('.mail-check:checked').map(function () {
                        return $(this).data('id');
                    }).get();

                    if (ids.length === 0) {
                        alert('Please select at least one notification to delete.');
                        return;
                    }

                    if (confirm('Are you sure you want to delete selected notifications?')) {
                        $.ajax({
                            url: '{{ route("notifications.bulkDelete") }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: ids
                            },
                            success: function () {
                                location.reload();
                            },
                            error: function () {
                                alert('Something went wrong. Please try again.');
                            }
                        });
                    }
                });

                $('.search-input').on('keyup', function () {
                    const value = $(this).val().toLowerCase();
                    $('.notification-row').each(function () {
                        $(this).toggle($(this).text().toLowerCase().includes(value));
                    });
                });
            });
        </script>
    @endpush
@endsection
