<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FretusFolks') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link defer rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.css">
    @stack('styles')
</head>

<body>
    <div class="sidebar active">
        <div class="logo_content">
            <div class="logo">
                <div href="">
                    <img src="{{ asset('admin/images/logo.png') }}" class="admin-logo" alt="">
                </div>
            </div>
            <i class='bx bx-menu-alt-right' id="btn" style="font-size: 25px; cursor: pointer;"></i>
        </div>
        <ul class="nav_list">
            <x-admin.side-bar />
        </ul>

    </div>
    <!-- top bar  -->


    <div class="home_content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row top_bar bg-white shadow-sm">
                        @include('admin.layout.top-bar')
                    </div>
                </div>
            </div>
        </div>

        <div class="main">
            <div class="row px-2">
                @if (session('success'))
                    <div class="col-lg-12 mt-2 session-success" id="session-success">
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <script>
                        toastr.error('{{ session('error') }}')
                    </script>
                @endif
            </div>
            {{ $slot }}
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script src="{{ asset('admin/js/main.js') }}"></script>
    <script src="{{ asset('admin/js/table.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(".profile-icon").click(function() {
                $(".profile-drop").toggle();
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let btn = document.querySelector("#btn");
            let sidebar = document.querySelector(".sidebar");
            let dropdownLinks = document.querySelectorAll(".dropdown");

            btn.onclick = function() {
                sidebar.classList.toggle("active");
            }

            dropdownLinks.forEach(link => {
                link.addEventListener("click", function(e) {

                    let dropdownMenu = this.querySelector(".dropdown_menu");
                    dropdownMenu.classList.toggle("open");
                });
            });
        });
    </script>
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.3.1/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.3.1/"
            }
        }
    </script>
    <script type="module">
        import {
            ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Italic,
            Font,
            List,
            Table,
            TableToolbar,
        } from 'ckeditor5';

        ClassicEditor
            .create(document.querySelector('#description'), {
                plugins: [Essentials, Paragraph, Bold, Italic, Font, List, Table, TableToolbar],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'bulletedList', 'numberedList',
                    'tableColumn', 'tableRow', 'mergeTableCells'
                ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    @stack('scripts')

</body>

</html>
