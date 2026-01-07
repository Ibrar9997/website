@extends('layouts.master')

@section('content')
    {{-- ADD Categories --}}

    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form id="categoryForm" action="{{ route('categories.store') }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="category_name" id="customername-field"
                                required>
                            <div class="invalid-feedback">Please enter a category name.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date of Added</label>
                            <input type="date" class="form-control" name="added_date" id="date-field" required>
                            <div class="invalid-feedback">Please select a date.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status" id="status-field" required>
                                <option value="">Select status</option>
                                <option value="Active">Active</option>
                                <option value="Block">Block</option>
                            </select>
                            <div class="invalid-feedback">Please select a status.</div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Category</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Delete Categories --}}
    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <input type="hidden" id="deleteCategoryId">

                    <h4>Are you sure?</h4>
                    <p class="text-muted">You want to delete this category?</p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="delete-record">
                        Yes, Delete
                    </button>
                </div>

            </div>
        </div>
    </div>



    {{-- ADD Category, Search Bar --}}

    <div class="card-body">
        <div class="listjs-table" id="customerList">
            <div class="row g-4 mb-3">
                <div class="col-sm-auto">
                    <div>
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                            data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Category</button>
                        {{-- <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button> --}}
                    </div>
                </div>
                <div class="col-sm">
                    <div class="d-flex justify-content-sm-end">
                        <div class="search-box ms-2">
                            <input type="text" class="form-control search" placeholder="Search...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Show Categories --}}

            <div class="table-responsive table-card mt-3 mb-1">
                <table class="table align-middle table-nowrap" id="customerTable">
                    <thead class="table-light">
                        <tr>
                            {{-- <th scope="col" style="width: 50px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                            </div>
                        </th> --}}
                            <th>Categories</th>
                            {{-- <th class="sort" data-sort="email">Email</th>
                        <th class="sort" data-sort="phone">Phone</th> --}}
                            <th>Date of Added</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->category_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d M, Y') }}</td>
                                <td>
                                    <span
                                        class="badge {{ $category->status == 'Active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $category->status }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-success edit-btn" data-id="{{ $category->id }}"
                                        data-name="{{ $category->category_name }}" data-status="{{ $category->status }}"
                                        data-bs-toggle="modal" data-bs-target="#showModal">
                                        Edit
                                    </button>

                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $category->id }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteRecordModal">
                                        Delete
                                    </button>


                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No categories found</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                <div class="noresult" style="display: none">
                    <div class="text-center">
                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                        <h5 class="mt-2">Sorry! No Result Found</h5>
                        <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any orders for you
                            search.</p>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="pagination-wrap hstack gap-2">
                    <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                        Previous
                    </a>
                    <ul class="pagination listjs-pagination mb-0"></ul>
                    <a class="page-item pagination-next" href="javascript:void(0);">
                        Next
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        // Reset modal when clicking ADD button
        $('#create-btn').on('click', function () {
            $('#categoryForm')[0].reset();
            $('#categoryForm').attr('action', '{{ route("categories.store") }}');
            $('input[name="_method"]').remove();
            $('.modal-title').text('Add Category');
        });
    </script> --}}
@endsection
@section('scripts')
    <script>
        let deleteId = null;

        // ADD CATEGORY
        $('#create-btn').on('click', function() {
            $('#categoryForm')[0].reset();
            $('#categoryForm').attr('action', '{{ route('categories.store') }}');
            $('input[name="_method"]').remove();
            $('#exampleModalLabel').text('Add Category');
        });

        // EDIT CATEGORY
        $('.edit-btn').on('click', function() {
            let id = $(this).data('id');

            $('#customername-field').val($(this).data('name'));
            $('#status-field').val($(this).data('status'));

            $('#categoryForm').attr('action', `/categories/${id}`);
            $('#categoryForm').append('<input type="hidden" name="_method" value="PUT">');

            $('#exampleModalLabel').text('Edit Category');
        });

        // DELETE MODAL
        $('.delete-btn').on('click', function() {
            deleteId = $(this).data('id');
            $('#deleteCategoryId').val(deleteId);
        });

        // DELETE AJAX
        $('#delete-record').on('click', function() {
            let id = $('#deleteCategoryId').val();

            $.ajax({
                url: `/categories/${id}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function() {
                    $('#deleteRecordModal').modal('hide');
                    $(`button[data-id="${id}"]`).closest('tr').remove();
                }
            });
        });
    </script>
@endsection
