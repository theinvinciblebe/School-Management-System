@extends('layout.main')
@section('content')

<style>
    .collapse-content {
        display: block;
        transition: all ease-in-out;
    }

</style>

<style>
        .file-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
        }

        .file-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
        }

        .file-item i {
            width: 30px;
        }

        .file-name {
            color: green;
            text-decoration: none;
            font-weight: bold;
        }

        .file-name:hover {
            text-decoration: underline;
        }

    </style>

<div style="margin: 0 10px">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Materials for subject <b>{{ $subject->name }}</b></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Materials</li>
                    </ol>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="timeline">

                    @forelse ($materials as $material)

                            <!-- Check conditions inside the loop -->
                        @if (!empty($material->title) || !empty($material->description) ||
                             (!empty($material->gallery_path) && json_decode($material->gallery_path, true) !== []) ||
                             (!empty($material->file_path) && json_decode($material->file_path, true) !== []) ||
                             (!empty($material->url_vdo) && json_decode($material->url_vdo, true) !== []))

                        <!-- Timeline time label -->
                            <div class="time-label">
                                <span class="bg-green">{{ date('d M Y', strtotime($material->created_at)) }}</span>
                            </div>
                            <!-- Timeline item -->
                            @if ($material->description)
                                <div>
                                    <i class="fas fa-book bg-blue toggle-icon" style="cursor: pointer;"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ date('h:i A', strtotime($material->created_at)) }}</span>
                                        <h3 class="timeline-header"><a href="#">{{ $material->author_name }}</a> {{ $material->title }}</h3>

                                        <div class="timeline-body collapse-content">
                                            {{ $material->description }}
                                        </div>

                                        @if(Auth::user()->role==0 || Auth::user()->role==1)
                                        <!-- Edit Button -->
                                        <div class="timeline-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success">Action</button>
                                                <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <button class="dropdown-item btn btn-primary edit-description-btn"
                                                            data-id="{{ $material->id }}"
                                                            data-title="{{ $material->title }}"
                                                            data-description="{{ $material->description }}">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>
                                                    <div class="dropdown-divider"></div>

                                                    <form action="{{ route('materials.deleteDescription', $material->id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            @endif

                            @if (!empty($material->gallery_path) && json_decode($material->gallery_path, true) !== [])
                                @php $gallery = json_decode($material->gallery_path, true) ?? []; @endphp


                                <div>
                                    <i class="fa fa-camera bg-purple toggle-icon" style="cursor: pointer;"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ date('h:i A', strtotime($material->created_at)) }}</span>
                                        <h3 class="timeline-header"><a href="#">{{ $material->author_name }}</a> uploaded new gallery</h3>
                                        <div class="timeline-body collapse-content">
                                            @foreach ($gallery as $img)
                                                <a href="{{ asset('upload_materials/' . $img) }}" target="_blank">
                                                    <img src="{{ asset('upload_materials/' . $img) }}" style="width: 150px; height: 150px" alt="Gallery Image">
                                                </a>
                                            @endforeach
                                        </div>
                                        @if(Auth::user()->role==0 || Auth::user()->role==1)
                                        <div class="timeline-footer">
{{--                                            <button class="btn btn-primary btn-sm edit-gallery-btn"--}}
{{--                                                    data-id="{{ $material->id }}"--}}
{{--                                                    data-gallery="{{ json_encode($gallery) }}">--}}
{{--                                                Edit Gallery--}}
{{--                                            </button>--}}
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success">Action</button>
                                                <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <button class="dropdown-item btn btn-primary edit-gallery-btn"
                                                            data-id="{{ $material->id }}"
                                                            data-gallery="{{ json_encode($gallery) }}">
                                                        <i class="fas fa-edit"></i>
                                                        Edit Gallery
                                                    </button>
                                                    <div class="dropdown-divider"></div>

                                                    <form action="{{ route('materials.deleteGallery', $material->id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if (!empty($material->file_path) && json_decode($material->file_path, true) !== [])

                                <div>
                                    <i class="fa fa-folder bg-dark toggle-icon" style="cursor: pointer;"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ date('h:i A', strtotime($material->created_at)) }}</span>
                                        <h3 class="timeline-header"><a href="#">{{ $material->author_name }}</a> uploaded new files</h3>
                                        <div class="timeline-body collapse-content">
                                            <div class="file-list">
                                                @php
                                                    $documents = json_decode($material->file_path, true) ?? [];
                                                @endphp

                                                @foreach ($documents as $doc)
                                                    @php
                                                        $fileExtension = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                                                        $icons = [
                                                            'pdf' => 'fa-file-pdf text-danger',
                                                            'doc' => 'fa-file-word text-primary',
                                                            'docx' => 'fa-file-word text-primary',
                                                            'ppt' => 'fa-file-powerpoint text-warning',
                                                            'pptx' => 'fa-file-powerpoint text-warning',
                                                            'xls' => 'fa-file-excel text-success',
                                                            'xlsx' => 'fa-file-excel text-success',
                                                            'txt' => 'fa-file-alt text-muted',
                                                        ];
                                                        $iconClass = $icons[$fileExtension] ?? 'fa-file text-secondary';
                                                    @endphp

                                                    <div class="file-item">
                                                        <i class="fas {{ $iconClass }} fa-2x"></i>
                                                        <a href="{{ asset('upload_materials/' . $doc) }}"
                                                           @if ($fileExtension === 'pdf') target="_blank" @else download @endif
                                                           class="file-name">
                                                            {{ basename($doc) }}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if(Auth::user()->role==0 || Auth::user()->role==1)
                                        <!-- Edit Button -->
                                        <div class="timeline-footer">
                                            {{--                                                <button class="btn btn-primary btn-sm edit-file-btn"--}}
                                            {{--                                                        data-id="{{ $material->id }}"--}}
                                            {{--                                                        data-file="{{ json_encode($documents) }}">--}}
                                            {{--                                                    Edit--}}
                                            {{--                                                </button>--}}
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success">Action</button>
                                                <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <button class="dropdown-item btn btn-primary edit-file-btn"
                                                            data-id="{{ $material->id }}"
                                                            data-file="{{ json_encode($documents) }}">
                                                        <i class="fas fa-edit"></i>
                                                        Edit Gallery
                                                    </button>
                                                    <div class="dropdown-divider"></div>

                                                    <form action="{{ route('materials.deleteFiles', $material->id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if (!empty($material->url_vdo) && json_decode($material->url_vdo, true) !== [])
                                @php $videos = json_decode($material->url_vdo, true) ?? []; @endphp

                                <div>
                                    <i class="fas fa-video bg-maroon toggle-icon" style="cursor: pointer;"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{ date('h:i A', strtotime($material->created_at)) }}</span>

                                        <h3 class="timeline-header"><a href="#">{{ $material->author_name }}</a> shared a video</h3>

                                        <div class="timeline-body collapse-content">
                                            @foreach ($videos as $vid)
                                                @if (strpos($vid, 'youtube.com/embed/') !== false)
                                                    <!-- YouTube Video -->
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="{{ $vid }}" width="360" height="315" allowfullscreen></iframe>
                                                    </div>

                                                @elseif (preg_match('/\.(mp4|avi|mov|mkv)$/i', $vid))
                                                    <!-- Local Video -->
                                                    <video width="100%" height="400" controls>
                                                        <source src="{{ asset('upload_materials/' . $vid) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>

                                                @else
                                                    <!-- External Video -->
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="{{ $vid }}" width="560" height="315" allowfullscreen></iframe>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <!-- Edit Button -->
                                        @if(Auth::user()->role==0 || Auth::user()->role==1)
                                        <div class="timeline-footer">
{{--                                            <button class="btn btn-primary btn-sm edit-video-btn"--}}
{{--                                                    data-id="{{ $material->id }}"--}}
{{--                                                    data-url="{{ $material->url_vdo ? htmlentities(json_encode(json_decode($material->url_vdo, true)), ENT_QUOTES, 'UTF-8') : '[]' }}">--}}
{{--                                                Edit Video--}}
{{--                                            </button>--}}
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success">Action</button>
                                                <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <button class="dropdown-item btn btn-primary edit-video-btn"
                                                            data-id="{{ $material->id }}"
                                                            data-url="{{ $material->url_vdo ? htmlentities(json_encode(json_decode($material->url_vdo, true)), ENT_QUOTES, 'UTF-8') : '[]' }}">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>
                                                    <div class="dropdown-divider"></div>

                                                    <form action="{{ route('materials.deleteVideos', $material->id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                        @endif

                                        {{--                                    @if ($material->video_type === 'local')--}}
                                        {{--                                        <!-- Local Video -->--}}
                                        {{--                                        <video width="100%" height="400" controls>--}}
                                        {{--                                            <source src="{{ $material->video_url }}" type="video/mp4">--}}
                                        {{--                                            Your browser does not support the video tag.--}}
                                        {{--                                        </video>--}}
                                        {{--                                    @endif--}}
                                    </div>
                                </div>
                            @endif
                        @endif
                        @empty
                            <div class="time-label">
                                <span class="bg-red">No Materials Found</span>
                            </div>
                        @endforelse

                        <!-- End timeline -->
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>


    @if(Auth::user()->role==0 || Auth::user()->role==1)
    <a href="{{ route('materials.create', ['subject_id' => $subject->subject_id]) }}" class="floating-button">
        <i class="fas fa-plus"></i>
    </a>
    @endif
    <a href="{{ route('getSubject.index', ['class_id' => $subject->class_id]) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>




<script>
    $(document).ready(function () {
        $(".toggle-icon").click(function () {
            $(this).siblings(".timeline-item").find(".collapse-content").slideToggle();
        });
    });
</script>

{{--script/edit-description---}}
<script>
    $(document).ready(function () {
        // Open modal and load data
        $(".edit-description-btn").click(function () {
            let id = $(this).data("id");
            let title = $(this).data("title");
            let description = $(this).data("description");

            $("#editMaterialId").val(id);
            $("#editTitle").val(title);
            $("#editDescription").val(description);

            $("#editDescriptionModal").modal("show");
        });

        // Submit the form using AJAX
        $("#editDescriptionForm").submit(function (e) {
            e.preventDefault();

            let id = $("#editMaterialId").val();
            let title = $("#editTitle").val();
            let description = $("#editDescription").val();

            $.ajax({
                url: "/materials/update-description/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    title: title,
                    description: description
                },
                success: function (response) {
                    alert("Description updated successfully!");
                    $("#desc-" + id).text(description); // Update the description on the page
                    $("#editDescriptionModal").modal("hide");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Error updating description!");
                }
            });
        });
    });
</script>

{{--script/edit-gallery---}}
<script>
    var base_url = "{{ asset('') }}"; // Laravel Base URL

    let currentGallery = []; // To store gallery images

    function displayGalleryImages() {
        let galleryHtml = "";
        currentGallery.forEach((image, index) => {
            galleryHtml += `
            <div class="gallery-item m-2">
                <img src="${base_url}upload_materials/${image}" class="img-thumbnail" width="100">
                <button class="btn btn-secondary btn-sm mt-1 remove-gallery" onclick="removeGalleryImage(${index})">❌</button>
            </div>
        `;
        });
        document.getElementById("currentGalleryContainer").innerHTML = galleryHtml;
    }

    function removeGalleryImage(index) {
        currentGallery.splice(index, 1); // Remove selected image
        displayGalleryImages();
    }

    function saveUpdatedGallery() {
        let materialId = $("#editGalleryMaterialId").val();
        let formData = new FormData();
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("material_id", materialId);
        formData.append("gallery", JSON.stringify(currentGallery));

        let files = $("#editGalleryFiles")[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append("gallery_files[]", files[i]);
        }

        fetch(`/materials/update-gallery/${materialId}`, {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Gallery updated successfully!");
                    location.reload();
                } else {
                    console.error("Error:", data.error);
                    alert("Failed to update gallery. Check console.");
                }
            })
            .catch(error => {
                console.error("Request failed:", error);
                alert("Server error. Please try again.");
            });
    }

    $(document).ready(function () {
        $(".edit-gallery-btn").click(function () {
            let materialId = $(this).data("id");
            let rawGalleryData = $(this).attr("data-gallery");

            try {
                let decodedGallery = $("<textarea/>").html(rawGalleryData).text();
                currentGallery = decodedGallery ? JSON.parse(decodedGallery) : [];

                console.log("Parsed Gallery Images:", currentGallery); // Debugging

                $("#editGalleryMaterialId").val(materialId);
                $("#editGalleryForm").attr("action", "/materials/update-gallery/" + materialId);
                displayGalleryImages();
                $("#editGalleryModal").modal("show");
            } catch (error) {
                console.error("JSON Parse Error:", error);
            }
        });
    });

</script>

{{--script/edit-video---}}
<script>
    var base_url = "{{ asset('') }}"; // Laravel Base URL

    let currentVideos = @json(isset($material) && $material->url_vdo ? json_decode($material->url_vdo, true) : []);

    function displayVideos() {
        let videoHtml = "";

        currentVideos.forEach((video, index) => {
            if (video.includes("youtube.com/embed/")) {
                // YouTube Video (Editable)
                videoHtml += `
                    <div class="video-item mb-2 d-flex align-items-center">
                        <input type="text" class="form-control w-75" value="${video}" onchange="updateVideo(${index}, this.value)">
                        <button class="btn btn-danger btn-sm ml-2" onclick="removeVideo(${index})">❌</button>
                    </div>
                `;
            } else {
                // Local Video (Preview & Remove)
                videoHtml += `
                    <div class="video-item mb-2">
                        <video width="200" controls>
                            <source src="${base_url}upload_materials/${video}" type="video/mp4">
                        </video>
                        <button class="btn btn-danger btn-sm mt-2" onclick="removeVideo(${index})">❌ Remove</button>
                    </div>
                `;
            }
        });

        document.getElementById("currentVideosContainer").innerHTML = videoHtml;
    }

    function updateVideo(index, newValue) {
        currentVideos[index] = newValue;
    }

    function removeVideo(index) {
        currentVideos.splice(index, 1);
        displayVideos();
    }

    function saveUpdatedVideos() {
        let materialId = $("#editVideoMaterialId").val();
        let newYouTubeUrls = $("#editVideoUrl").val().split(",").map(url => url.trim()).filter(url => url !== "");
        let allVideos = [...newYouTubeUrls, ...currentVideos];

        let formData = new FormData();
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("material_id", materialId);
        formData.append("videos", JSON.stringify(allVideos));

        // Append video files
        let files = $("#editVideoFile")[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append("video_files[]", files[i]);
        }

        fetch(`/materials/update-video/${materialId}`, {
            method: "POST",
            body: formData
        }) .then(data => {
            if (data.success) {
                alert("Videos updated successfully!");
                location.reload();
            } else {
                console.error("Error:", data.error);
                alert("Failed to update videos. Check console.");
            }
        })
            .catch(error => {
                console.error("Request failed:", error);
                alert("Server error. Please try again.");
            });
    }

    $(document).ready(function () {
        $(".edit-video-btn").click(function () {
            let materialId = $(this).data("id");
            let rawVideoUrls = $(this).attr("data-url");

            try {
                // Convert HTML entities back to normal JSON format
                let decodedUrls = $("<textarea/>").html(rawVideoUrls).text();
                let videoUrls = decodedUrls ? JSON.parse(decodedUrls) : [];

                console.log("Parsed Video URLs:", videoUrls); // Debugging

                // Set Material ID
                $("#editVideoMaterialId").val(materialId);
                $("#editVideoForm").attr("action", "/materials/update-video/" + materialId);

                // Populate YouTube URLs (comma-separated)
                $("#editVideoUrl").val(videoUrls.filter(url => url.includes("youtube.com")).join(", "));

                // Populate Local Videos
                let currentVideosHtml = "";
                let base_url = "{{ asset('') }}";

                videoUrls.forEach(video => {
                    if (!video.includes("youtube.com")) {
                        currentVideosHtml += `
                        <div class="video-item mb-2">
                            <video width="200" controls>
                                <source src="${base_url}upload_materials/${video}" type="video/mp4">
                            </video>
                            <button class="btn btn-secondary btn-sm mt-2 remove-video" data-video="${video}">❌ Remove</button>
                        </div>
                    `;
                    }
                });

                $("#currentVideosContainer").html(currentVideosHtml);
                $("#editVideoModal").modal("show");
            } catch (error) {
                console.error("JSON Parse Error:", error);
            }
        });

        // Handle Video Removal
        $(document).on("click", ".remove-video", function () {
            let videoToRemove = $(this).data("video");
            let videos = $("#editVideoUrl").val().split(", ").filter(v => v !== videoToRemove);
            $("#editVideoUrl").val(videos.join(", "));
            $(this).parent().remove();
        });
    });


</script>

{{--script/edit-file---}}
<script>
    var base_url = "{{ asset('') }}"; // Laravel Base URL
    let currentFiles = [];

    $(document).ready(function () {
        // Open Edit File Modal
        $(".edit-file-btn").click(function () {
            let materialId = $(this).data("id");
            let rawFiles = $(this).attr("data-file");

            try {
                let decodedFiles = $("<textarea/>").html(rawFiles).text();
                currentFiles = decodedFiles ? JSON.parse(decodedFiles) : [];
            } catch (error) {
                console.error("JSON Parse Error:", error);
            }

            $("#editFileMaterialId").val(materialId);
            displayCurrentFiles();
            $("#editFileModal").modal("show");
        });

        // Remove file from current files list
        $(document).on("click", ".remove-file", function () {
            let fileToRemove = $(this).data("file");
            currentFiles = currentFiles.filter(file => file !== fileToRemove);
            displayCurrentFiles();
        });
    });

    // Display current files with remove option
    function displayCurrentFiles() {
        let filesHtml = "";
        currentFiles.forEach((file, index) => {
            filesHtml += `
            <div class="d-flex align-items-center mb-2">
                <a href="${base_url}upload_materials/${file}" target="_blank" class="mr-2">${file.split('/').pop()}</a>
                <button class="btn btn-secondary btn-sm remove-file" data-file="${file}">❌</button>
            </div>
        `;
        });
        $("#currentFilesList").html(filesHtml);
    }

    // Save Updated Files
    function saveUpdatedFiles() {
        let materialId = $("#editFileMaterialId").val();
        let formData = new FormData();
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("material_id", materialId);
        formData.append("existing_files", JSON.stringify(currentFiles));

        // Append newly uploaded files
        let files = $("#editFiles")[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append("new_files[]", files[i]);
        }

        fetch(`/materials/update-files/${materialId}`, {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Files updated successfully!");
                    location.reload();
                } else {
                    console.error("Error:", data.error);
                    alert("Failed to update files. Check console.");
                }
            })
            .catch(error => {
                console.error("Request failed:", error);
                alert("Server error. Please try again.");
            });
    }


</script>


@endsection

<!-- Edit Description Modal -->
<div class="modal fade" id="editDescriptionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Description</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editDescriptionForm">
                    @csrf
                    <input type="hidden" id="editMaterialId">

                <div class="form-group">
                    <label for="editTitle">Title</label>
                    <input type="text" id="editTitle" class="form-control">
                </div>

                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <textarea id="editDescription" class="form-control" rows="6"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Video Modal -->
<div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editVideoForm" method="POST">
                    @csrf
                    <input type="hidden" name="material_id" id="editVideoMaterialId">

                    <!-- YouTube Video URL Input -->
                    <div class="form-group">
                        <label for="editVideoUrl">YouTube Video URLs (comma-separated)</label>
                        <textarea class="form-control" id="editVideoUrl" placeholder="Enter YouTube URLs, separated by commas"></textarea>
                    </div>

                    <p class="text-center font-weight-bold">OR</p>

                    <!-- Local Video File Upload -->
                    <div class="form-group">
                        <label for="editVideoFile">Upload Video File (MP4, AVI, MOV, MKV)</label>
                        <input type="file" name="video_file[]" id="editVideoFile" class="form-control" multiple>
                    </div>

                    <!-- Current Videos -->
                    <div class="form-group">
                        <label>Current Videos:</label>
                        <div id="currentVideosContainer"></div>
                    </div>

                    <button type="button" class="btn btn-success" onclick="saveUpdatedVideos()">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit File Modal -->
<div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Documents</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editFileForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="material_id" id="editFileMaterialId">

                    <!-- Upload New Files -->
                    <div class="form-group">
                        <label for="editFiles">Upload New Documents (PDF, DOCX, PPTX, etc.)</label>
                        <input type="file" name="new_files[]" id="editFiles" class="form-control" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar">
                    </div>

                    <!-- Current Files -->
                    <div class="form-group">
                        <label>Current Files:</label>
                        <div id="currentFilesList" class="d-flex flex-column"></div>
                    </div>

                    <button type="button" class="btn btn-success" onclick="saveUpdatedFiles()">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Gallery Modal -->
<div id="editGalleryModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editGalleryMaterialId">

                <!-- Upload New Images -->
                <div class="form-group">
                    <label for="editGalleryFiles">Upload New Images (JPEG, PNG, JPG, GIF)</label>
                    <input type="file" name="new_gallery[]" id="editGalleryFiles" class="form-control" multiple accept=".jpeg,.png,.jpg,.gif">
                </div>

                <hr>
                <label>Current Gallery Images:</label>
                <div id="currentGalleryContainer" class="d-flex flex-wrap">
                    <!-- Images will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveUpdatedGallery()">Save Changes</button>
            </div>
        </div>
    </div>
</div>
