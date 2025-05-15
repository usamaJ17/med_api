<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('dashboard/images/favicon.ico') }}">

    <title> @yield('title') </title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('dashboard/css/vendors_css.css') }}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/skin_color.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.min.css" rel="stylesheet">
    @yield('css')
</head>

<body class="hold-transition dark-skin sidebar-mini theme-success fixed">

    <div class="wrapper">
        <div id="loader"></div>

        @include('dashboard.layouts.header')

        @include('dashboard.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                @yield('content')
                <!-- /.content -->
            </div>
        </div>
        <!-- /.content-wrapper -->
        @include('dashboard.layouts.footer')


    </div>
    <!-- ./wrapper -->
    {{-- @include('dashboard.layouts.chat') --}}

    <!-- Page Content overlay -->


    <!-- Vendor JS -->
    <script src="{{ asset('dashboard/js/vendors.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/pages/chat-popup.js') }}"></script>
    <script src="{{ asset('dashboard/assets/icons/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset('dashboard/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor_components/OwlCarousel2/dist/owl.carousel.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor_components/datatable/datatables.min.js') }}"></script>
    


    <!-- Rhythm Admin App -->
    <script src="{{ asset('dashboard/js/template.js') }}"></script>

    <script src="{{ asset('dashboard/js/pages/dashboard2.js') }}"></script>
    <!--<script src="{{ asset('dashboard/assets/vendor_components/ckeditor/ckeditor.js') }}"></script> -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js">
    </script>-->
    <!--<script src="{{ asset('dashboard/js/pages/editor.js') }}"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-alignment@39.0.1/build/alignment.min.js"></script>
    <script>
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }
            upload() {
                return this.loader.file
                    .then(file => {
                        const data = new FormData();
                        data.append('upload', file);

                        return fetch('/portal/upload-file', {
                                method: 'POST',
                                body: data,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel example
                                }
                            })
                            .then(response => response.json())
                            .then(data => ({
                                default: data.url
                            }));
                    });
            }
            abort() {}
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = loader => {
                return new MyUploadAdapter(loader);
            };
        }
        class CustomEditor extends ClassicEditor {}

        CustomEditor.builtinPlugins = [
            ...ClassicEditor.builtinPlugins,
            window.Alignment // Add the Alignment plugin
        ];

        ClassicEditor
            .create(document.querySelector('#editor1'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                        'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'blockQuote', '|',
                        'undo', 'redo', '|',
                        'fontColor', 'fontBackgroundColor', '|',
                        'alignment', '|',
                        'outdent', 'indent', '|',
                        'removeFormat', '|',
                        'imageUpload', 'mediaEmbed', 'insertTable', '|',
                        'maximize', 'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true // Prevents grouping of toolbar items
                },
                fontSize: {
                    options: [
                        9, 11, 13, 'default', 17, 19, 21, 25, 27, 29
                    ]
                },
                alignment: {
                    options: ['left', 'center', 'right', 'justify'] // Add the alignment options
                },
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side'],
                    styles: ['full', 'side']
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                },
                // Set editor height via CSS
                height: 300,
                width: '100%',
                removePlugins: ['EasyImage', 'MediaEmbed'] // Remove plugins if not needed
            })
            .catch(error => {
                console.error(error);
            });
        let editorInstance;
        ClassicEditor
            .create(document.querySelector('#editor2'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                        'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'blockQuote', '|',
                        'undo', 'redo', '|',
                        'fontColor', 'fontBackgroundColor', '|',
                        'alignment', '|',
                        'outdent', 'indent', '|',
                        'removeFormat', '|',
                        'imageUpload', 'mediaEmbed', 'insertTable', '|',
                        'maximize', 'sourceEditing'
                    ],
                    shouldNotGroupWhenFull: true // Prevents grouping of toolbar items
                },
                fontSize: {
                    options: [
                        9, 11, 13, 'default', 17, 19, 21, 25, 27, 29
                    ]
                },
                alignment: {
                    options: ['left', 'center', 'right', 'justify'] // Add the alignment options
                },
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side'],
                    styles: ['full', 'side']
                },
                table: {
                    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                },
                // Set editor height via CSS
                height: 300,
                width: '100%',
                removePlugins: ['EasyImage', 'MediaEmbed'] // Remove plugins if not needed
            })
            .then(editor => {
                editorInstance = editor; // Store the editor instance for later use
            })
            .catch(error => {
                console.error(error);
            });

        function editEditor(data) {
            editorInstance.setData(data);
        }
        console.log(ClassicEditor.builtinPlugins.map(plugin => plugin.pluginName));
        // 			new FroalaEditor("#editor");
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('script')

</body>

</html>
