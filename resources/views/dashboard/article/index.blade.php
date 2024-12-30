@extends('dashboard.layouts.app')

@section('title')
    Article
@endsection
@section('article')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Article</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Article</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive rounded card-table">
                            <table class="table border-no" id="example1">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Details</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($articles as $article)
                                        <tr class="hover-primary">
                                            <td>{{ $article->title }}</td>
                                            <td> 
                                                @if ($article->user)
                                                    {{ $article->user->fullName() }}
                                                @else
                                                    N/A
                                                @endif
                                            <td>
                                                @if ($article->published == 1)
                                                    <span style="color: green;">Approved</span>
                                                @else
                                                    <span style="color: red;">Rejected</span>
                                                @endif
                                            </td>
                                            <td><a href="{{ route('articles.admin.show', $article->id) }}" class="btn btn-sm btn-success">View</a></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                        data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="dropdown-item" onclick="editArticle({{ $article->id }})">Edit</a>
                                                        <a class="dropdown-item"
                                                            onclick="ChangeStatus({{ $article->id }},'approve')">Approve</a>
                                                        <a class="dropdown-item"
                                                            onclick="ChangeStatus({{ $article->id }},'reject')">Reject</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="edit_article_modal" tabindex="-1" role="dialog" aria-labelledby="editArticleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editArticleLabel">Edit Article</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editArticleForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <!-- Title Field -->
                    <div class="form-group">
                        <label for="edit_title">Title</label>
                        <input type="text" name="title" class="form-control" id="edit_title" required>
                    </div>

                    <!-- Body Field -->
                    <div class="form-group">
                        <label for="editor2">Body</label>
                        <textarea id="editor2" name="body" rows="10" cols="80"></textarea>
                    </div>

                    <!-- Category Field -->
                    <div class="form-group">
                        <label for="edit_category_id">Category</label>
                        <select name="category_id" class="form-control" id="edit_category_id" required>
                            <option value="" disabled>Select a Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Thumbnail Upload -->
                    <div class="form-group">
                        <label for="edit_thumbnail" class="form-label">Thumbnail</label>
                        <div class="input-group">
                            <input type="file" name="thumbnail" class="form-control" id="edit_thumbnail" accept="image/*">
                        </div>
                    </div>

                    <!-- Media Upload -->
                    <div class="form-group">
                        <label for="edit_media" class="form-label">Upload Media</label>
                        <div class="input-group">
                            <input type="file" name="media" class="form-control" id="edit_media" accept="audio/*,video/*,image/*">
                        </div>
                        <small class="form-text text-muted">Supported formats: audio, video, images.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <div class="modal fade" id="add_new" tabindex="-1" role="dialog" aria-labelledby="addNewArticleLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewArticleLabel">Add New Article</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('articles.admin.store') }}" method="POST" enctype="multipart/form-data">
                     
                    <div class="modal-body">
                       @csrf
                        <!-- Title Field -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" required>
                        </div>

                        <!-- Body Field -->
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea id="editor1" name="body" rows="10" cols="80">
						    </textarea>
                        </div>

                        <!-- Category Field -->
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control" id="category_id" required>
                                <option value="" disabled selected>Select a Category</option>
                                <!-- Populate dynamically from database -->
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Thumbnail Upload -->
                        <div class="form-group">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <div class="input-group">
                                <input type="file" name="thumbnail" class="form-control" id="thumbnail" accept="image/*">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="media" class="form-label">Upload Media</label>
                            <div class="input-group">
                                <input type="file" name="media" class="form-control" id="media" accept="audio/*,video/*,image/*">
                                
                            </div>
                            <small class="form-text text-muted">Supported formats: audio, video, images.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @endsection
    @section('script')
        <script>
            function editArticle(articleId) {
                $.ajax({
                    url: `articles/${articleId}/edit`, // Adjust to your route
                    type: 'GET',
                    success: function(response) {
                        // Populate the form fields with response data
                        $('#edit_title').val(response.title);
                        // $('#edit_body').html(response.body);
                        CKEDITOR.instances['editor2'].setData(response.body);
                        $('#edit_category_id').val(response.category_id);

                        // Set form action URL
                        $('#editArticleForm').attr('action', `articles/${articleId}`);

                        // Show the modal
                        $('#edit_article_modal').modal('show');
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Failed to fetch article details.');
                    }
                });
            }

            $(function() {
                'use strict';
                $('#example1').DataTable({
                    'paging': true,
                    'lengthChange': false,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': false,
                    'dom': 'Bfrtip',
                    'buttons': [{
                        text: 'Add New Article',
                        className: 'waves-effect waves-light btn btn-sm btn-success mb-5', // Add your custom classes here
                        action: function(e, dt, node, config) {
                            $('#add_new').modal('show'); // Show the modal
                        }
                    }]
                })
            });
            // Open modal to edit an existing reminder
            function editReminder(id, title, note, role) {
                $('#edit_title').val(title); // Set the title
                $('#edit_note').val(note); // Set the note
                $('#edit_role').val(role); // Set the role
                $('#editForm').attr('action', '/portal/reminder/' + id); // Set form action for update
                $('#form_method').val('PUT'); // Set form method for updating the reminder
                $('#edit_modal').modal('show'); // Show the modal
            }

            function ChangeStatus(id, status) {
                $.ajax({
                    url: "{{ url('portal/articles/status') }}",
                    type: 'POSt',
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        id: id
                    },
                    success: function(response) {
                        // reload page
                        location.reload();
                    }
                });
            }
        </script>
    @endsection
