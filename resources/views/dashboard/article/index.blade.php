@extends('dashboard.layouts.app')

@section('title')
    Article
@endsection
@section('article')
    active
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <style>
        .ql-snow .ql-stroke {
            stroke: #fbfbfb !important;
        }
        .ql-snow .ql-fill, .ql-snow .ql-stroke.ql-fill {
            fill: #fbfbfb !important;
        }
        .ql-snow .ql-picker {
            color: #fbfbfb !important;
        }
        .ql-snow .ql-picker-options {
            background-color: #112547 !important;
        }
        .ql-snow .ql-picker-options .ql-picker-item {
            color: fbfbfb;
        }
    </style>
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
                                                @if ($article->published == 2)
                                                    <span style="color: yellow;">Pending</span>
                                                @elseif ($article->published == 1)
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
                                                        <a href="#" class="dropdown-item" onclick="deleteArticle({{ $article->id }})">Delete</a>
                                                        @if ($article->published == 2)
                                                            <a class="dropdown-item"
                                                               onclick="ChangeStatus({{ $article->id }},'approve')">Approve</a>
                                                            <a class="dropdown-item"
                                                               onclick="ChangeStatus({{ $article->id }},'reject')">Reject</a>
                                                        @elseif ($article->published == 1)
                                                            <a class="dropdown-item"
                                                               onclick="ChangeStatus({{ $article->id }},'reject')">Reject</a>
                                                        @else
                                                            <a class="dropdown-item"
                                                               onclick="ChangeStatus({{ $article->id }},'approve')">Approve</a>
                                                        @endif
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
    <style>
       .ck-editor__editable {
    /* Ensure proper dimensions */
    min-height: 300px; /* Matches your CKEditor height configuration */
    max-height: auto;
    overflow: auto;

    /* Ensure proper padding and appearance */
    padding: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #fff;
    font-size: 14px; /* Adjust font size */
    font-family: Arial, sans-serif; /* Match your page styling */
}

    </style>
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
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <!-- Title Field -->
                        <div class="form-group">
                            <label for="edit_title">Title</label>
                            <input type="text" name="title" class="form-control" id="edit_title" required>
                        </div>
                        <div> 
                            <input type="hidden" name="body" id="body_edit_content">
                            <div id="editor_edit"></div>
                        </div>
                        <div class="form-group">
                            <label for="edit_category_id">Category</label>
                            <select name="category_id" class="form-control" id="edit_category_id" required>
                                <option value="" disabled>Select a Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" class="form-control" id="edit_slug" required>
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
                        <button type="button" id="update_article" class="btn btn-primary">Save Changes</button>
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
                <form action="{{ route('articles.admin.store') }}" method="POST" enctype="multipart/form-data" id="add_form">
                    <div class="modal-body">
                       @csrf
                        <!-- Title Field -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" required>
                        </div>
                        <input type="hidden" name="body" id="body_content">
                        <div id="editor">
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
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" name="slug" class="form-control" id="slug" required>
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
                        <button type="button" class="btn btn-primary" id="save_article">Save Article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endsection

    @section('script')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <script>
            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],       
                ['blockquote', 'code-block'],
                ['link', 'image', 'formula'],

                [{ 'header': 1 }, { 'header': 2 }],              
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],     
                [{ 'indent': '-1'}, { 'indent': '+1' }],         
                [{ 'direction': 'rtl' }],

                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                [{ 'color': [] }, { 'background': [] }],         
                [{ 'font': [] }],
                [{ 'align': [] }],

                ['clean']                                        
            ];
            const quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions,
                },
                placeholder: 'Start your article...',
            });
            addWebPImageUploadingFunctionality(quill);
            $('#save_article').on('click' , function() {
                $('#body_content').val(quill.root.innerHTML)
                $('#add_form').submit();
            });
            const quill2 = new Quill('#editor_edit', {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions,
                },
                placeholder: 'Start your article...',
            });
            addWebPImageUploadingFunctionality(quill2);
            function addWebPImageUploadingFunctionality(editorInstance) {
                const toolbar = editorInstance.getModule('toolbar');
                toolbar.addHandler('image', function () {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/webp, image/*');
                    input.click();
                    input.onchange = function () {
                        const file = input.files[0];
                        if (file) {
                            // Ensure the file is an image
                            if (!file.type.startsWith('image/')) {
                                alert('Please upload a valid image.');
                                return;
                            }
                            const reader = new FileReader();
                            reader.onload = function () {
                                const range = editorInstance.getSelection();
                                const base64Image = reader.result;
                                editorInstance.insertEmbed(range.index, 'image', base64Image);
                            };
                            reader.readAsDataURL(file);
                        }
                    };
                });
            }
            
            function deleteArticle(name) {
                $.ajax({
                    url : "{{ url('portal/articles/delete') }}/" + name,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // reload page
                        location.reload();
                    }
                });
            }
            function editArticle(articleId) {
                $.ajax({
                    url: `articles/${articleId}/edit`, // Adjust to your route
                    type: 'GET',
                    success: function(response) {
                        // Populate the form fields with response data
                        $('#edit_title').val(response.title);
                        $('#edit_slug').val(response.slug);
                        $('#editor2').val(response.body);
                        $('#edit_category_id').val(response.category_id);
                        quill2.deleteText(0, quill2.getLength());
                        quill2.clipboard.dangerouslyPasteHTML(0, response.body);
                        $('#editArticleForm').attr('action', `articles/${articleId}`);
                        $('#edit_article_modal').modal('show');
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Failed to fetch article details.');
                    }
                });
            }
            $('#update_article').on('click', function() {
                $('#body_edit_content').val(quill2.root.innerHTML);
                $('#editArticleForm').submit();
            });

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
                            $('#add_new').modal('show');
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
