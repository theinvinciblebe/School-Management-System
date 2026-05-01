@extends('layout.main')
@section('content')

    <div class="row" style="justify-content: center">
        <div class="col-md-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Brand Logo & Title</h3>
                </div>
                <div class="card-body text-center">
                    <!-- Display Existing Logo -->
                    <div class="mb-3">
                        <h5>Current Logo</h5>
                        <img id="current-logo" src="{{ asset('customize_images/' . ($customizes->brand_logo ?? 'noimg.jpg')) }}"
                             alt="Brand Logo" class="img-thumbnail" style="width: 150px; height: auto;">
                    </div>

                    <!-- Dropzone for Upload -->
                    <form action="{{ route('customize.updateLogo') }}" method="POST" enctype="multipart/form-data"
                          class="dropzone" id="logoDropzone">
                        @csrf
                        <div class="dz-message">
                            <p class="text-muted">
                            Drag & Drop or Click to Upload New Logo
                            </p>
                        </div>
                    </form>

                    <!-- Button to Submit the Upload -->
{{--                    <button id="uploadBtn" class="btn btn-primary mt-3">--}}
{{--                        <i class="fas fa-upload"></i> Upload New Logo--}}
{{--                    </button>--}}

{{--                    <button data-dz-remove class="btn btn-danger delete mt-3">--}}
{{--                        <i class="fas fa-trash"></i>--}}
{{--                        <span>Delete</span>--}}
{{--                    </button>--}}

                </div>

                <div class="card-footer">
                    <div class="mb-3">
                        <h5>Current Brand Title</h5>
                        <input type="text" id="brandTitleInput" class="form-control" value="{{ $customizes->brand_title ?? 'Default Title' }}">
                        <button id="updateBrandTitleBtn" class="btn btn-primary mt-2">
                            <i class="fas fa-save"></i> Update Title
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Update URL Icon & Title</h3>
                </div>
                <div class="card-body text-center">
                    <!-- Display Existing Logo -->
                    <div class="mb-3">
                        <h5>Current Icon</h5>
                        <img id="current-icon" src="{{ asset('' . ($customizes->url_icon ?? 'noimg.jpg')) }}"
                             alt="URL Icon" class="img-thumbnail" style="width: 150px; height: auto;">
                    </div>

                    <!-- Dropzone for Upload -->
                    <form action="{{ route('customize.updateIcon') }}" method="POST" enctype="multipart/form-data"
                          class="dropzone" id="iconDropzone">
                        @csrf
                        <div class="dz-message">
                            <p class="text-muted">
                                Drag & Drop or Click to Upload New Icon <br>
                                * We suggest to convert image to file ico before upload *
                            </p>
                        </div>
                    </form>

                    <!-- Button to Submit the Upload -->
{{--                    <button id="uploadBtn" class="btn btn-primary mt-3">--}}
{{--                        <i class="fas fa-upload"></i> Upload New Logo--}}
{{--                    </button>--}}

{{--                    <button data-dz-remove class="btn btn-danger delete mt-3">--}}
{{--                        <i class="fas fa-trash"></i>--}}
{{--                        <span>Delete</span>--}}
{{--                    </button>--}}

                </div>

                <div class="card-footer">
                    <div class="mb-3">
                        <h5>Current URL Title</h5>
                        <input type="text" id="urlTitleInput" class="form-control" value="{{ $customizes->url_title ?? 'Default Title' }}">
                        <button id="updateURLTitleBtn" class="btn btn-secondary mt-2">
                            <i class="fas fa-save"></i> Update Title
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card col-md-3">
            <div class="card-body">
                <h6>Navbar Color</h6>
                <div class="d-flex">
                    <select id="navbarTheme" class="form-control custom-select mb-3 text-light border-0">

                        <option value="bg-primary" class="bg-primary text-light">Primary</option>
                        <option value="bg-secondary" class="bg-secondary text-light">Secondary</option>
                        <option value="bg-info" class="bg-info text-light">Info</option>
                        <option value="bg-success" class="bg-success text-light">Success</option>
                        <option value="bg-danger" class="bg-danger text-light">Danger</option>
                        <option value="bg-indigo" class="bg-indigo text-light">Indigo</option>
                        <option value="bg-purple" class="bg-purple text-light">Purple</option>
                        <option value="bg-pink" class="bg-pink text-light">Pink</option>
                        <option value="bg-navy" class="bg-navy text-light">Navy</option>
                        <option value="bg-lightblue" class="bg-lightblue text-light">Lightblue</option>
                        <option value="bg-teal" class="bg-teal text-light">Teal</option>
                        <option value="bg-cyan" class="bg-cyan text-light">Cyan</option>
                        <option value="bg-darkred" class="bg-darkred text-light">Darkred</option>
                        <option value="bg-gray-dark" class="bg-gray-dark text-light">Gray dark</option>
                        <option value="bg-gray" class="bg-gray text-light">Gray</option>
                        <option value="bg-light" class="bg-light text-light">Light</option>
                        <option value="bg-warning" class="bg-warning text-light">Warning</option>
                        <option value="bg-orange" class="bg-orange text-light">Orange</option>
                    </select>
                </div>

                <h6>Accent Color Variants</h6>
                <div class="d-flex">
                    <select id="accentTheme" class="form-control custom-select mb-3 text-dark border-0">
                        <option value="" class="bg-default text-dark">Default</option>
                        <option value="accent-primary" class="bg-primary text-dark">Primary</option>
                        <option value="accent-secondary" class="bg-secondary text-dark">Secondary</option>
                        <option value="accent-info" class="bg-info text-dark">Info</option>
                        <option value="accent-success" class="bg-success text-dark">Success</option>
                        <option value="accent-danger" class="bg-danger text-dark">Danger</option>
                        <option value="accent-indigo" class="bg-indigo text-light">Indigo</option>
                        <option value="accent-purple" class="bg-purple text-light">Purple</option>
                        <option value="accent-pink" class="bg-pink text-light">Pink</option>
                        <option value="accent-navy" class="bg-navy text-light">Navy</option>
                        <option value="accent-lightblue" class="bg-lightblue text-light">Lightblue</option>
                        <option value="accent-teal" class="bg-teal text-light">Teal</option>
                        <option value="accent-cyan" class="bg-cyan text-light">Cyan</option>
                        <option value="accent-darkred" class="bg-darkred text-light">Darkred</option>
                        <option value="accent-dark" class="bg-dark text-light">Dark</option>
                        <option value="accent-gray-dark" class="bg-gray-dark text-light">Gray dark</option>
                        <option value="accent-gray" class="bg-gray text-light">Gray</option>
                        <option value="accent-light" class="bg-light text-light">Light</option>
                        <option value="accent-warning" class="bg-warning text-light">Warning</option>
                        <option value="accent-orange" class="bg-orange text-light">Orange</option>
                    </select>
                </div>

                <h6>Sidebar Color</h6>
                <div class="d-flex">
                    <select id="sidebarTheme" class="form-control custom-select mb-3 text-light border-0">

                        <option value="bg-primary" class="bg-primary text-light">Primary</option>
                        <option value="bg-secondary" class="bg-secondary text-light">Secondary</option>
                        <option value="bg-info" class="bg-info text-light">Info</option>
                        <option value="bg-success" class="bg-success text-light">Success</option>
                        <option value="bg-danger" class="bg-danger text-light">Danger</option>
                        <option value="bg-indigo" class="bg-indigo text-light">Indigo</option>
                        <option value="bg-purple" class="bg-purple text-light">Purple</option>
                        <option value="bg-pink" class="bg-pink text-light">Pink</option>
                        <option value="bg-navy" class="bg-navy text-light">Navy</option>
                        <option value="bg-lightblue" class="bg-lightblue text-light">Lightblue</option>
                        <option value="bg-teal" class="bg-teal text-light">Teal</option>
                        <option value="bg-cyan" class="bg-cyan text-light">Cyan</option>
                        <option value="bg-darkred" class="bg-darkred text-light">Darkred</option>
                        <option value="bg-gray-dark" class="bg-gray-dark text-light">Gray dark</option>
                        <option value="bg-gray" class="bg-gray text-light">Gray</option>
                        <option value="bg-light" class="bg-light text-light">Light</option>
                        <option value="bg-warning" class="bg-warning text-light">Warning</option>
                        <option value="bg-orange" class="bg-orange text-light">Orange</option>
                    </select>
                </div>

                <h6>Dark Sidebar Variants</h6>
                <div class="d-flex">
                    <select id="dSide" class="form-control mb-3 text-light border-0">

                        <option value="sidebar-dark-primary" class="bg-primary text-light">Primary</option>
                        <option value="sidebar-dark-secondary" class="bg-secondary text-light">Secondary</option>
                        <option value="sidebar-dark-info" class="bg-info text-light">Info</option>
                        <option value="sidebar-dark-success" class="bg-success text-light">Success</option>
                        <option value="sidebar-dark-danger" class="bg-danger text-light">Danger</option>
                        <option value="sidebar-dark-indigo" class="bg-indigo text-light">Indigo</option>
                        <option value="sidebar-dark-purple" class="bg-purple text-light">Purple</option>
                        <option value="sidebar-dark-pink" class="bg-pink text-light">Pink</option>
                        <option value="sidebar-dark-navy" class="bg-navy text-light">Navy</option>
                        <option value="sidebar-dark-lightblue" class="bg-lightblue text-light">Lightblue</option>
                        <option value="sidebar-dark-teal" class="bg-teal text-light">Teal</option>
                        <option value="sidebar-dark-cyan" class="bg-cyan text-light">Cyan</option>
                        <option value="sidebar-dark-dark" class="bg-dark text-light">Dark</option>
                        <option value="sidebar-dark-gray-dark" class="bg-gray-dark text-light">Gray dark</option>
                        <option value="sidebar-dark-gray" class="bg-gray text-light">Gray</option>
                        <option value="sidebar-dark-light" class="bg-light text-light">Light</option>
                        <option value="sidebar-dark-warning" class="bg-warning text-light">Warning</option>
                        <option value="sidebar-dark-orange" class="bg-orange text-light">Orange</option>
                    </select>
                </div>

                <button id="saveThemeBtn" class="btn btn-primary mt-3">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async function () {
            let navbarTheme = document.getElementById("navbarTheme");
            let sidebarTheme = document.getElementById("sidebarTheme");
            let accentTheme = document.getElementById("accentTheme");
            let DarkSidebarTheme = document.getElementById("dSide");
            let navbarMain = document.getElementById("mainNav");
            let bodyMain = document.getElementById("mainBody");
            let sidebarMain = document.querySelector(".main-sidebar"); // Sidebar Element
            let saveThemeBtn = document.getElementById("saveThemeBtn");

            // Function to set the correct dropdown value
            function setDropdownValue(selectElement, savedValue) {
                // Convert "sidebar-dark-warning" → "bg-warning"
                // let bgColor = savedValue.replace("sidebar-dark-", "bg-")
                //     .replace("sidebar-light-", "bg-")
                //     .replace("accent-", "bg-");

                for (let option of selectElement.options) {
                    if (option.value === savedValue) { // Match the transformed value
                        option.selected = true;
                        selectElement.className = `form-control custom-select mb-3 border-0 ${savedValue}`;
                        selectElement.value = savedValue; // Corrected value assignment
                        break;
                    }
                }
            }



            // Function to update navbar color
            function updateNavbarColor(selectedValue) {
                navbarMain.classList.forEach((cls) => {
                    if (cls.startsWith("bg-")) {
                        navbarMain.classList.remove(cls);
                    }
                });

                navbarMain.classList.add(selectedValue);
                setDropdownValue(navbarTheme, selectedValue);
            }

            // Function to update accent color
            function updateAccentColor(selectedValue) {
                bodyMain.classList.forEach((cls) => {
                    if (cls.startsWith("accent-")) {
                        bodyMain.classList.remove(cls);
                    }
                });

                bodyMain.classList.add(selectedValue);
                setDropdownValue(accentTheme, selectedValue);
            }

            // Function to update sidebar color
            function updateSidebarColor(selectedValue) {
                sidebarMain.classList.forEach((cls) => {
                    if (cls.startsWith("bg-")) {
                        sidebarMain.classList.remove(cls);
                    }
                });

                sidebarMain.classList.add(selectedValue);
                setDropdownValue(sidebarTheme, selectedValue);
            }

            // Function to update sidebar color
            function updateSidebarVariant(selectedValue) {
                sidebarMain.classList.forEach((cls) => {
                    if (cls.startsWith("sidebar-dark-") || cls.startsWith("sidebar-light-")) {
                        sidebarMain.classList.remove(cls);
                    }
                });

                sidebarMain.classList.add(selectedValue);
                setDropdownValue(DarkSidebarTheme, selectedValue);
            }

            try {
                // 🔹 Fetch Current Theme Settings from DB
                let response = await fetch("{{ route('customize.getTheme') }}");
                let data = await response.json();

                if (data.nav_color) {
                    updateNavbarColor(data.nav_color);
                }
                if (data.accent_color) {
                    updateAccentColor(data.accent_color);
                }
                if (data.sidebar_color) {
                    updateSidebarColor(data.sidebar_color);
                }
                if (data.dark_sidebar_variants) {
                    updateSidebarVariant(data.dark_sidebar_variants);
                }
            } catch (error) {
                console.error("Error fetching theme settings:", error);
            }

            // 🔹 Update navbar when dropdown selection changes
            navbarTheme.addEventListener("change", function () {
                updateNavbarColor(navbarTheme.value);
            });

            // 🔹 Update navbar when dropdown selection changes
            accentTheme.addEventListener("change", function () {
                updateAccentColor(accentTheme.value);
            });

            // 🔹 Update sidebar when dropdown selection changes
            sidebarTheme.addEventListener("change", function () {
                updateSidebarColor(sidebarTheme.value);
            });

            DarkSidebarTheme.addEventListener("change", function () {
                updateSidebarVariant(DarkSidebarTheme.value);
            });

            // 🔹 Save the Selected Themes to DB
            saveThemeBtn.addEventListener("click", async function () {
                let selectedNavbar = navbarTheme.value;
                let selectedAccent = accentTheme.value;
                let selectedSidebar = sidebarTheme.value;
                let selectedDSidebar = DarkSidebarTheme.value;

                try {
                    let response = await fetch("{{ route('customize.updateTheme') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            nav_color: selectedNavbar,
                            accent_color: selectedAccent,
                            sidebar_color: selectedSidebar,
                            dark_sidebar_variants: selectedDSidebar
                        })
                    });

                    let data = await response.json();
                    if (data.success) {
                        location.reload(); // ✅ Reload page to apply new themes
                    } else {
                        alert("⚠️ Failed to update theme.");
                    }
                } catch (error) {
                    console.error("Error updating theme:", error);
                }
            });
        });



    </script>

    <script>
        document.getElementById("updateBrandTitleBtn").addEventListener("click", function () {
            let newTitle = document.getElementById("brandTitleInput").value;

            if (newTitle.trim() === "") {
                alert("Brand title cannot be empty!");
                return;
            }

            fetch("{{ route('customize.updateBrandTitle') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({ brand_title: newTitle })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                    } else {
                        alert("Failed to update brand title.");
                    }
                })
                .catch(error => console.error("Error updating brand title:", error));
        });

    </script>

    <script>
        document.getElementById("updateURLTitleBtn").addEventListener("click", function () {
            let newTitle = document.getElementById("urlTitleInput").value;

            if (newTitle.trim() === "") {
                alert("URL title cannot be empty!");
                return;
            }

            fetch("{{ route('customize.updateURLTitle') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({ url_title: newTitle })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                    } else {
                        alert("Failed to update url title.");
                    }
                })
                .catch(error => console.error("Error updating brand title:", error));
        });

    </script>

    <script>

        Dropzone.autoDiscover = false;

        var myDropzone = new Dropzone("#logoDropzone", {
            url: "{{ route('customize.updateLogo') }}", // Upload URL
            method: "post",
            paramName: "file",
            maxFiles: 1, // Only one file allowed
            acceptedFiles: "image/jpeg, image/png, image/jpg, image/gif, image/x-icon",
            addRemoveLinks: true,
            dictDefaultMessage: "Drag & Drop or Click to Upload New Logo",
            autoProcessQueue: false, // Prevent automatic upload
            uploadMultiple: false,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            init: function () {
                var dz = this;

                //  Prevent auto-upload when file is added
                dz.on("addedfile", function (file) {
                    console.log("File added, waiting for upload button click...");
                });

                //  Handle successful upload
                dz.on("success", function (file, response) {
                    alert("Logo Updated Successfully!");
                    document.getElementById("current-logo").src = response.newLogoUrl; // Update displayed logo
                });

                //  Handle upload button click
                document.getElementById("uploadBtn").addEventListener("click", function () {
                    if (dz.getQueuedFiles().length > 0) {
                        dz.processQueue(); // Upload only when clicked
                    } else {
                        alert("Please select a file to upload.");
                    }
                });
            }
        });
        var myDropzone = new Dropzone("#iconDropzone", {
            url: "{{ route('customize.updateIcon') }}", // Upload URL
            method: "post",
            paramName: "file",
            maxFiles: 1, // Only one file allowed
            acceptedFiles: "image/jpeg, image/png, image/jpg, image/gif, image/x-icon",
            addRemoveLinks: true,
            dictDefaultMessage: "Drag & Drop or Click to Upload New Logo",
            autoProcessQueue: false, // Prevent automatic upload
            uploadMultiple: false,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            init: function () {
                var dz = this;

                //  Prevent auto-upload when file is added
                dz.on("addedfile", function (file) {
                    console.log("File added, waiting for upload button click...");
                });

                //  Handle successful upload
                dz.on("success", function (file, response) {
                    alert("Logo Updated Successfully!");
                    document.getElementById("current-icon").src = response.newLogoUrl; // Update displayed logo
                });

                //  Handle upload button click
                document.getElementById("uploadBtn").addEventListener("click", function () {
                    if (dz.getQueuedFiles().length > 0) {
                        dz.processQueue(); // Upload only when clicked
                    } else {
                        alert("Please select a file to upload.");
                    }
                });
            }
        });



    </script>


@endsection
