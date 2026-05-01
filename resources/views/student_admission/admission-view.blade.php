<!DOCTYPE html>
<html>
<head>
    <title>Admission Form</title>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
{{--    <script src="https://unpkg.com/html2pdf.js@0.10.1/dist/html2pdf.bundle.min.js"></script>--}}

    <style>
    *{
        justify-content: center;
        align-items: center;
    }
    @media print {
        html, body {
            overflow: hidden !important;
            width: 100% !important;
            background-color: #ffffff;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 12px;
            -webkit-print-color-adjust: exact !important; /* Ensures colors print */
            print-color-adjust: exact !important;

        }
        button{
            display: none !important;
        }
    }
    @page {
        size: A4 portrait;  /* Defines A5 size in portrait orientation */
        margin: 0;
        overflow: hidden;
        /*bleed: 3mm; !* (Optional) Adds a bleed for printing *!*/
        /*marks: crop; !* (Optional) Adds crop marks for printing *!*/
    }
</style>

    <script>
        function createPdfDocument() {
            const element = document.getElementById('pdf-content');

            const options = {
                margin:       0.5,
                filename:     'admission-form.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(options).from(element).save().then(() => {
                console.log("PDF download triggered");

            });
        }
    </script>

</head>
<body class="bg-gray-200 p-6 rounded shadow">

    <div id="pdf-content" class="max-w-6xl mx-auto p-12 space-y-4 bg-white rounded shadow">
        <div style="height: 100px;">
            <a href="https://mawaridtech.com/" rel="home">
                <img fetchpriority="high" style="width: 80px; height: 80px; margin-left: 50px;" src="https://log.mawaridtech.com/customize_images/1747990172.png" alt="Mawarid logo">
            </a>
            <h1 class="text-3xl font-bold align-center">ADMISSION FORM</h1>
        </div>

        <div class="max-w-6xl p-6 bg-white">
            <div>
                <h2 class="text-xl font-semibold border-b pb-2 mb-4 forminator-title">PERSONAL INFORMATION</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="block font-medium mb-1">Full Name </label>
                        <input type="text" name="name" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->full_name ?? 'N/A'}}" disabled>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Email Address</label>
                        <input type="email" name="email" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->gmail ?? 'N/A'}}" disabled>

                    </div>

                    <div>
                        <label class="block font-medium mb-1">Gender</label>
                        <input type="email" name="email" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->gender ?? 'N/A'}}" disabled>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Date of Birth</label>
                        <input type="date" name="dob" class="w-full border rounded px-3 py-2 forminator-input"  value="{{ $admission->dob ?? 'N/A'}}" disabled>

                    </div>

                    <div>
                        <label class="block font-medium mb-1">Phone</label>
                        <input type="text" name="phone" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->phone ?? 'N/A'}}" disabled>

                    </div>
                    <div>
                        <label class="block font-medium mb-1">ZIP / Postal Code</label>
                        <input type="text" name="zip" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->zip ?? 'N/A'}}" disabled>

                    </div>

                    @php
                        $address = implode(', ', array_filter([
                        $admission->apartment,
                        $admission->street,
                        $admission->province,
                        $admission->city,
                        $admission->country
                        ]));
                        @endphp

                    <div class="md:col-span-2">
                        <label class="block font-medium mb-1">Address</label>
                        <input type="text" name="state" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $address ?? 'N/A'}}" disabled>
                    </div>



                </div>
            </div>
            <br>
            <div>
                <h2 class="text-xl font-semibold border-b pb-2 mb-4 forminator-title">COURSE APPLYING FOR</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="block font-medium mb-1">Courses</label>
                        <input type="text" name="course" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->course ?? 'N/A'}}" disabled>

                    </div>

                    <div>
                        <label class="block font-medium mb-1">Mode of Study</label>
                        <input type="text" name="mode" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->mode ?? 'N/A'}}" disabled>

                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-medium mb-1">Subject</label>
                        <input type="text" name="subject" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->subject ?? 'N/A'}}" disabled>
                    </div>
                </div>
            </div>
            <br>
            <h2 class="text-xl font-semibold border-b pb-2 mb-4 forminator-title">EDUCATIONAL BACKGROUND</h2>
            <div>
                @php
                    $educationRaw = $admission->education ?? '[]';
                    $educationArray = json_decode($educationRaw, true) ?? [];
                    $educationList = implode(', ', $educationArray);
                @endphp
                <label class="block font-medium mb-1">Educational Background</label>
                <input type="text" name="education" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $educationList ?: 'N/A' }}" disabled>
            </div>

            <h2 class="text-xl font-semibold border-b pb-2 mt-4 forminator-title">WORK EXPERIENCE</h2>
            <br>
            <div>
                <label class="block font-medium mb-1">Work Experience</label>
                <input type="text" name="work_exp" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->work_exp ?? 'N/A'}}" disabled>
            </div>

            <h2 class="text-xl font-semibold border-b pb-2 mt-6 forminator-title">GUARDIAN CONTACT</h2>
        <br>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <div>
                    <label class="block font-medium mb-1">Name </label>
                    <input type="text" name="guardian_name" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->guardian_name ?? 'N/A'}}" disabled>
                </div>

                <div>
                    <label class="block font-medium mb-1">Relationship</label>
                    <input type="text" name="guardian_relationship" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->guardian_relationship ?? 'N/A'}}" disabled>
                </div>

                <div>
                    <label class="block font-medium mb-1">Email Address </label>
                    <input type="email" name="guardian_email" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->guardian_email ?? 'N/A'}}" disabled>
                </div>

                <div>
                    <label class="block font-medium mb-1">Phone <span class="forminator-required"></span></label>
                    <input type="text" name="guardian_phone" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->guardian_phone ?? 'N/A'}}" disabled>
                </div>
            </div>

            <div>
                <label class="block font-medium mb-1 mt-4">Reference</label>
                <input type="text" name="reference" class="w-full border rounded px-3 py-2 forminator-input" value="{{ $admission->reference ?? 'N/A'}}" disabled>

            </div>
        </div>
        <div class="max-w-lg mx-auto mt-4 text-right">
            <button onclick="window.print()" class="float-right bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center space-x-2 shadow-md">
                <i class="fas fa-print"></i>
                <span>Print</span>
            </button>
            <button
                onclick="createPdfDocument()"
                class="float-left bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center space-x-2">
                <i class="fas fa-download"></i>
                <span>Generate PDF</span>
            </button>
        </div>
    </div>

</body>


</html>





