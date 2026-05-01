@extends('layout.main')
@section('content')

    <style>
        input[type="file"] {
            display: none;
        }

        .upload-label {
            min-height: 200px;
            width: 100%;
            border-radius: 6px;
            margin: 10px 0 20px 0;
            border: 1px dashed #999;
            text-align: center;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            gap: 10px;
            padding: 15px;
        }

        .upload-label:hover {
            color: #de0611;
            border: 1px dashed #de0611;
        }

        .upload-label.drag-over {
            border-color: #007bff;
            background-color: #f0f8ff;
        }

        .upload-label img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
            position: relative;
        }
        #uploadText, #videoText, #docText{
            font-size: 20px;
        }

        .preview-box {
            position: relative;
            display: inline-block;
        }

        .remove-btn {
            opacity: 0;
            transition: opacity 0.2s;
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 14px;
            width: 22px;
            height: 22px;
            cursor: pointer;
        }

        .remove-btn-small {
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            margin-left: 10px;
            cursor: pointer;
        }

        .preview-box:hover .remove-btn {
            opacity: 1;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #ccc;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

    </style>

    <style>
        .progress {
            background-color: #eee;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #28a745;
            height: 100%;
            color: white;
            text-align: center;
            transition: width 0.3s;
        }

        #uploadOverlay {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.85);
            align-items: center;
            justify-content: center;
        }
    </style>

    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Create New Material</h1>
                <a href="{{ route('class.materials', ['subject_id' => $subject->subject_id]) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <form id="materialUploadForm" action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="subject_id" value="{{ $subject->subject_id }}">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-bullhorn" aria-hidden="true"></i> General</h5>
                            </div>
                            <div class="card-body">
                                <!-- Description Title -->
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter title...">
                                </div>
                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" placeholder="Enter description..." rows="6"></textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Save Material
                                </button>

                                <!-- Progress Bar -->
                                {{--                        <div class="progress mt-3" style="height: 20px;">--}}
                                {{--                            <div id="uploadProgressBar" class="progress-bar" style="width: 0%;">0%</div>--}}
                                {{--                        </div>--}}
                            </div>

                        </div>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-image" aria-hidden="true"></i> Upload Images</h5>
                            </div>
                            <div class="card-body">
                                <!-- Upload Images in Label -->
                                <div class="form-group">
                                    <label for="galleryInput" id="galleryLabel" class="upload-label">
                                        <div id="uploadText">
                                            <span>Click or drag images here to upload</span><br>
                                            <i class="fas fa-cloud-upload-alt fa-2x mt-2"></i>
                                        </div>
                                        <div id="spinner" class="spinner" style="display: none;"></div>
                                        <!-- Previews will appear inside this label -->
                                    </label>
                                    <input type="file" id="galleryInput" name="gallery_path[]" multiple accept="image/*">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Save Material
                                </button>

                                <!-- Progress Bar -->
                                {{--                        <div class="progress mt-3" style="height: 20px;">--}}
                                {{--                            <div id="uploadProgressBar" class="progress-bar" style="width: 0%;">0%</div>--}}
                                {{--                        </div>--}}
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-folder" aria-hidden="true"></i> Upload Documents</h5>
                            </div>
                            <div class="card-body">
                                <!-- Upload Documents -->
                                <div class="form-group">
                                    <label for="documentInput" id="documentLabel" class="upload-label">
                                        <div id="docText">
                                            <span>Click or drag documents here (PDF, DOCX, PPT, ZIP, RAR...)</span><br>
                                            <i class="fas fa-file-upload fa-2x mt-2"></i>
                                        </div>
                                        <ul id="docPreviewList" class="mt-2"></ul>
                                    </label>
                                    <input type="file" id="documentInput" name="file_path[]" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Save Material
                                </button>

                                <!-- Progress Bar -->
                                {{--                        <div class="progress mt-3" style="height: 20px;">--}}
                                {{--                            <div id="uploadProgressBar" class="progress-bar" style="width: 0%;">0%</div>--}}
                                {{--                        </div>--}}
                            </div>

                        </div>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-film" aria-hidden="true"></i> Upload Videos Or URLs</h5>
                            </div>
                            <div class="card-body">
                                <!-- YouTube Video URL (Multiple Allowed) -->
                                <div class="form-group">
                                    <label for="url_vdo">YouTube Video URLs (Separate by Comma)</label>
                                    <input type="text" name="url_vdo" class="form-control" placeholder="Enter YouTube URLs, separated by commas">
                                </div>

                                <!-- Upload Video Files -->
                                <div class="form-group">
                                    <label for="videoInput" id="videoLabel" class="upload-label">
                                        <div id="videoText">
                                            <span>Click or drag video files here</span><br>
                                            <i class="fas fa-video fa-2x mt-2"></i>
                                        </div>
                                        <ul id="videoPreviewList" class="mt-2"></ul>
                                    </label>
                                    <input type="file" id="videoInput" name="video_file[]" multiple accept="video/mp4,video/avi,video/mov,video/mkv">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Save Material
                                </button>

                                <!-- Progress Bar -->
                                {{--                        <div class="progress mt-3" style="height: 20px;">--}}
                                {{--                            <div id="uploadProgressBar" class="progress-bar" style="width: 0%;">0%</div>--}}
                                {{--                        </div>--}}
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Progress Overlay (Initially hidden) -->
    <div id="uploadOverlay">
        <div style="width: 60%; max-width: 600px;">
            <div class="progress" style="height: 25px;">
                <div id="uploadProgressBar" class="progress-bar" style="width: 0%;">0%</div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.getElementById("galleryInput");
        const label = document.getElementById("galleryLabel");
        const uploadText = document.getElementById("uploadText");
        const spinner = document.getElementById("spinner");

        function showSpinner() {
            spinner.style.display = "block";
        }

        function hideSpinner() {
            spinner.style.display = "none";
        }

        function createImagePreview(file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement("img");
                img.src = e.target.result;

                const box = document.createElement("div");
                box.classList.add("preview-box");

                const removeBtn = document.createElement("button");
                removeBtn.classList.add("remove-btn");
                removeBtn.innerHTML = "✖";
                removeBtn.addEventListener("click", function (e) {
                    e.stopPropagation(); // Prevent the label click
                    e.preventDefault();  // Optional: block default action too
                    box.remove();
                    if (label.querySelectorAll(".preview-box").length === 0) {
                        uploadText.style.display = "block";
                    }
                });


                box.appendChild(img);
                box.appendChild(removeBtn);
                label.appendChild(box);
            };
            reader.readAsDataURL(file);
        }

        input.addEventListener("change", function () {
            if (this.files.length > 0) {
                uploadText.style.display = "none";
            }
            showSpinner();
            setTimeout(() => {
                Array.from(this.files).forEach(file => {
                    createImagePreview(file);
                });
                hideSpinner();
            }, 300); // simulate spinner delay
        });

        // Drag and Drop support
        ["dragenter", "dragover"].forEach(eventName => {
            label.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                label.classList.add("drag-over");
            });
        });

        ["dragleave", "drop"].forEach(eventName => {
            label.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                label.classList.remove("drag-over");
            });
        });

        label.addEventListener("drop", function (e) {
            const files = Array.from(e.dataTransfer.files);
            if (files.length > 0) {
                uploadText.style.display = "none";
                showSpinner();

                // Create DataTransfer for assigning files
                const dataTransfer = new DataTransfer();

                setTimeout(() => {
                    files.forEach(file => {
                        if (file.type.startsWith("image/")) {
                            createImagePreview(file);
                            dataTransfer.items.add(file); // <-- Add to input
                        }
                    });

                    // Assign dropped files to input
                    input.files = dataTransfer.files;

                    hideSpinner();
                }, 300);
            }
        });


    });
</script>
<script>
    function setupDragAndDrop(inputId, labelId, textId, previewListId, fileTypeCheck) {
        const input = document.getElementById(inputId);
        const label = document.getElementById(labelId);
        const text = document.getElementById(textId);
        const previewList = document.getElementById(previewListId);

        // Highlight drag-over
        ["dragenter", "dragover"].forEach(event => {
            label.addEventListener(event, (e) => {
                e.preventDefault();
                e.stopPropagation();
                label.classList.add("drag-over");
            });
        });

        // Remove highlight
        ["dragleave", "drop"].forEach(event => {
            label.addEventListener(event, (e) => {
                e.preventDefault();
                e.stopPropagation();
                label.classList.remove("drag-over");
            });
        });

        // Handle dropped files
        label.addEventListener("drop", function (e) {
            const files = Array.from(e.dataTransfer.files);
            if (files.length > 0) {
                text.style.display = "none";
                previewList.innerHTML = "";
                files.forEach(file => {
                    if (fileTypeCheck(file)) {
                        const li = document.createElement("li");
                        li.textContent = file.name;

                        const removeBtn = document.createElement("button");
                        removeBtn.className = "remove-btn-small";
                        removeBtn.innerHTML = "×";
                        removeBtn.addEventListener("click", function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            li.remove();
                            if (!previewList.children.length) {
                                text.style.display = "block";
                            }
                        });

                        li.appendChild(removeBtn);
                        previewList.appendChild(li);
                    }
                });

                // Put dropped files into the input manually
                const dataTransfer = new DataTransfer();
                files.forEach(file => {
                    if (fileTypeCheck(file)) dataTransfer.items.add(file);
                });
                input.files = dataTransfer.files;
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Apply to Documents
        setupDragAndDrop(
            "documentInput",
            "documentLabel",
            "docText",
            "docPreviewList",
            file => file.type.match(/application\/|text\//)
        );

        // Apply to Videos
        setupDragAndDrop(
            "videoInput",
            "videoLabel",
            "videoText",
            "videoPreviewList",
            file => file.type.startsWith("video/")
        );
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Generic preview handler for file names
        function handleFilePreview(inputId, previewListId, textId) {
            const input = document.getElementById(inputId);
            const previewList = document.getElementById(previewListId);
            const text = document.getElementById(textId);

            input.addEventListener("change", function () {
                previewList.innerHTML = "";
                text.style.display = this.files.length ? "none" : "block";

                Array.from(this.files).forEach((file, index) => {
                    const li = document.createElement("li");
                    li.innerText = file.name;

                    const removeBtn = document.createElement("button");
                    removeBtn.className = "remove-btn-small";
                    removeBtn.innerHTML = "×";
                    removeBtn.addEventListener("click", function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        li.remove();
                        if (!previewList.children.length) {
                            text.style.display = "block";
                        }
                    });

                    li.appendChild(removeBtn);
                    previewList.appendChild(li);
                });
            });
        }

        handleFilePreview("documentInput", "docPreviewList", "docText");
        handleFilePreview("videoInput", "videoPreviewList", "videoText");
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("materialUploadForm");
        const overlay = document.getElementById("uploadOverlay");

        if (!form) {
            console.warn("Form not found!");
            return;
        }

        const progressBar = document.getElementById("uploadProgressBar");

        form.addEventListener("submit", function (e) {
            e.preventDefault();

            overlay.style.display = "flex"; // Triggers flex layout when uploading
            document.body.style.overflow = "hidden"; // Optional: prevent background scroll

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            xhr.open("POST", "{{ route('materials.store') }}", true);


            xhr.upload.addEventListener("progress", function (e) {
                if (e.lengthComputable) {
                    const percent = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = percent + "%";
                    progressBar.textContent = percent + "%";
                }
            });

            xhr.onload = function () {
                if (xhr.status === 200) {
                    progressBar.classList.add("bg-success");
                    progressBar.textContent = "Upload Complete!";
                    // Go back
                    setTimeout(() => {
                        window.location.href = "{{ route('class.materials', ['subject_id' => $subject->subject_id]) }}";
                    }, 1000); // Optional delay to show success
                } else {
                    progressBar.classList.add("bg-danger");
                    progressBar.textContent = "Upload Failed!";
                }
            };

            xhr.send(formData);
        });
    });
</script>



