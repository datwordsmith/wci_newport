<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Contact Messages
            @if($this->unreadCount > 0)
                <span class="badge bg-danger">{{ $this->unreadCount }} unread</span>
            @endif
        </h2>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" class="form-control" wire:model.live="search" placeholder="Search messages...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" wire:model.live="statusFilter">
                        <option value="all">All Messages</option>
                        <option value="unread">Unread</option>
                        <option value="read">Read</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select class="form-select" wire:model.live="categoryFilter">
                        <option value="all">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ ucfirst(str_replace('_', ' ', $category)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-outline-secondary w-100" wire:click="$refresh">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="card">
        <div class="card-body">
            @if($messages->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th wire:click="sortBy('is_read')" style="cursor: pointer;">
                                    Status
                                    @if($sortField === 'is_read')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th wire:click="sortBy('name')" style="cursor: pointer;">
                                    Name
                                    @if($sortField === 'name')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th wire:click="sortBy('email')" style="cursor: pointer;">
                                    Email
                                    @if($sortField === 'email')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th wire:click="sortBy('category')" style="cursor: pointer;">
                                    Category
                                    @if($sortField === 'category')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th wire:click="sortBy('subject')" style="cursor: pointer;">
                                    Subject
                                    @if($sortField === 'subject')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                                    Date
                                    @if($sortField === 'created_at')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                                <tr class="{{ !$message->is_read ? 'table-warning' : '' }}">
                                    <td>
                                        @if($message->is_read)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Read
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-envelope"></i> Unread
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $message->name }}</strong>
                                        @if(!$message->is_read)
                                            <i class="fas fa-circle text-danger" style="font-size: 6px; margin-left: 5px;"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $message->email }}" class="text-decoration-none">
                                            {{ $message->email }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ ucfirst(str_replace('_', ' ', $message->category)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $message->subject }}">
                                            {{ $message->subject }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $message->created_at->format('M j, Y g:i A') }}
                                            <br>
                                            <span class="text-muted">{{ $message->created_at->diffForHumans() }}</span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-outline-primary" wire:click="viewMessage({{ $message->id }})" title="View Message">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            @if($message->is_read)
                                                <button class="btn btn-outline-warning" wire:click="markAsUnread({{ $message->id }})" title="Mark as Unread">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-outline-success" wire:click="markAsRead({{ $message->id }})" title="Mark as Read">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif

                                            <button class="btn btn-outline-danger" wire:click="confirmDelete({{ $message->id }})" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing {{ $messages->firstItem() }} to {{ $messages->lastItem() }} of {{ $messages->total() }} results
                    </div>
                    <div>
                        {{ $messages->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No messages found</h5>
                    <p class="text-muted">
                        @if($search || $statusFilter !== 'all' || $categoryFilter !== 'all')
                            Try adjusting your filters to see more results.
                        @else
                            Contact messages will appear here when visitors submit the contact form.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Message View Modal -->
    @if($showModal && $selectedMessage)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5); z-index: 9999;">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-envelope-open me-2"></i>
                            Message from {{ $selectedMessage->name }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Name:</strong> {{ $selectedMessage->name }}
                            </div>
                            <div class="col-md-6">
                                <strong>Email:</strong>
                                <a href="mailto:{{ $selectedMessage->email }}">{{ $selectedMessage->email }}</a>
                            </div>
                        </div>

                        @if($selectedMessage->phone)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Phone:</strong>
                                    <a href="tel:{{ $selectedMessage->phone }}">{{ $selectedMessage->phone }}</a>
                                </div>
                                <div class="col-md-6">
                                    <strong>Category:</strong>
                                    <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $selectedMessage->category)) }}</span>
                                </div>
                            </div>
                        @else
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Category:</strong>
                                    <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $selectedMessage->category)) }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <strong>Subject:</strong> {{ $selectedMessage->subject }}
                        </div>

                        <div class="mb-3">
                            <strong>Message:</strong>
                            <div class="border rounded p-3 bg-light mt-2">
                                {!! nl2br(e($selectedMessage->message)) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>Received:</strong> {{ $selectedMessage->created_at->format('M j, Y g:i A') }}
                                </small>
                            </div>
                            @if($selectedMessage->is_read)
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <strong>Read by:</strong> {{ $selectedMessage->read_by_email }}<br>
                                        <strong>Read at:</strong> {{ $selectedMessage->read_at->format('M j, Y g:i A') }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if(!$selectedMessage->is_read)
                            <button class="btn btn-success" wire:click="markAsRead({{ $selectedMessage->id }})">
                                <i class="fas fa-check me-2"></i>Mark as Read
                            </button>
                        @endif
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal && $messageToDelete)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5); z-index: 9999;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Confirm Delete
                        </h5>
                        <button type="button" class="btn-close btn-close-white" wire:click="cancelDelete"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                            <h5>Are you sure you want to delete this message?</h5>
                            <p class="text-muted">This action cannot be undone.</p>
                        </div>
                        
                        <div class="border rounded p-3 bg-light">
                            <div class="row mb-2">
                                <div class="col-sm-3"><strong>From:</strong></div>
                                <div class="col-sm-9">{{ $messageToDelete->name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3"><strong>Email:</strong></div>
                                <div class="col-sm-9">{{ $messageToDelete->email }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3"><strong>Subject:</strong></div>
                                <div class="col-sm-9">{{ $messageToDelete->subject }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"><strong>Date:</strong></div>
                                <div class="col-sm-9">{{ $messageToDelete->created_at->format('M j, Y g:i A') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cancelDelete">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-danger" wire:click="deleteMessage">
                            <i class="fas fa-trash me-2"></i>Yes, Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
