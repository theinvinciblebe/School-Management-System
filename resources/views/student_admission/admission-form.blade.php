<!DOCTYPE html>
<html>
<head>
    <title>Admission Form</title>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        *::selection{
            background-color: #E04562;
        }
        p{
            font-size: 16px;
            color: #4e4e4e;
        }
        .block{
            font-size: 16px;
            font-weight: bold;
            color: #4e4e4e;
        }
        .forminator-required {
            color: #E04562;
        }
        .forminator-input {
            height: auto;
            border: 1px solid #777771; /* Added explicit border width and style */
            background-color: #edcbcb;
            color: #000000;
            font-size: 16px;
            font-family: inherit;
            font-weight: 400;
            padding: 8px 12px; /* Added padding for better text spacing */
            border-radius: 4px; /* Added subtle rounded corners */
            transition: all 0.3s ease; /* Smooth transition for hover effects */
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }

        .forminator-input:hover,
        .forminator-input:valid,
        .forminator-input:active{ /* Combined hover and focus states */
            border-color: #4098fd;
            background-color: #d1d1f1;
            outline: none; /* Removes default browser outline */
            box-shadow: 0 0 0 2px rgba(64, 152, 253, 0.2); /* Adds subtle glow */
        }

        /* Removed :active as it's similar to :hover in this case */
        .forminator-title {
            color: #4e4e4e;
            font-size: 35px;
            font-family: inherit;
            font-weight: 400;
            text-align: left;
        }

        /*.forminator-radio-label{*/
        /*    color: #000000;*/
        /*    cursor: pointer;*/
        /*    pointer-events: all;*/
        /*    display: block;*/

        /*}*/

        .border-red-500 {
            border-color: #ef4444;
            border-width: 2px;
        }
        .select2-container--default .select2-results__option img {
            width: 20px;
            height: 15px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .select2-selection__rendered img {
            width: 20px;
            height: 15px;
            margin-right: 10px;
            vertical-align: middle;
        }

        /* Style for both checkboxes and radio buttons container */
        .space-y-2 label, .flex label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin-bottom: 0.25rem;
            font-weight: normal;
        }

        /* Hide default inputs */
        input[type="checkbox"],
        input[type="radio"] {
            position: absolute;
            opacity: 0;
            height: 0;
            width: 0;
        }

        /* Custom checkbox */
        input[type="checkbox"] + span {
            position: relative;
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid #777771;
            border-radius: 3px;
            background-color: #fff;
            transition: all 0.2s ease;
        }

        /* Custom radio */
        input[type="radio"] + span {
            position: relative;
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid #777771;
            border-radius: 50%;
            background-color: #fff;
            transition: all 0.2s ease;
        }

        /* Checkbox checked state */
        input[type="checkbox"]:checked + span {
            background-color: #4098fd;
            border-color: #4098fd;
        }

        /* Radio checked state */
        input[type="radio"]:checked + span {
            background-color: #fff;
            border-color: #4098fd;
        }

        /* Checkmark for checkbox */
        input[type="checkbox"]:checked + span::after {
            content: "";
            position: absolute;
            left: 5px;
            top: 1px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Inner dot for radio */
        input[type="radio"]:checked + span::after {
            content: "";
            position: absolute;
            top: 3px;
            left: 3px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #4098fd;
        }

        /* Focus states */
        input[type="checkbox"]:focus + span,
        input[type="radio"]:focus + span {
            box-shadow: 0 0 0 3px rgba(64, 152, 253, 0.3);
        }

        /* Hover states */
        input[type="checkbox"]:hover + span,
        input[type="radio"]:hover + span {
            border-color: #4098fd;
        }

        /* Disabled state */
        input[type="checkbox"]:disabled + span,
        input[type="radio"]:disabled + span {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .mode-of-study label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin-right: 1rem;
            white-space: nowrap; /* Prevents label text wrapping */
        }

        .forminator-error-message {
            display: none;
            font-size: 12px;
            font-family: inherit;
            font-weight: 500;
            padding: 2px 10px;
            border-radius: 2px;
            line-height: 2em;
            margin: 5px 0 0;
            background-color: #F9E4E8;
            color: #E04562;
        }

        .error { color: red; }
        .success { color: green; }
    </style>


    <style>
        /* Target the Select2 container (the visible element) */
        .select2-container--default .select2-selection--single {
            height: auto !important;
            border: 1px solid #777771 !important;
            background-color: #edcbcb !important;
            color: #000000 !important;
            font-size: 16px !important;
            font-family: inherit !important;
            font-weight: 400 !important;
            padding: 8px 12px !important;
            border-radius: 4px !important;
        }

        /* Hover state */
        .select2-container--default .select2-selection--single:hover {
            border-color: #4098fd !important;
            background-color: #d1d1f1 !important;
        }

        /* Focus state */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #4098fd !important;
            background-color: #d1d1f1 !important;
            box-shadow: 0 0 0 2px rgba(64, 152, 253, 0.2) !important;
        }

        /* Dropdown styling */
        .select2-container--default .select2-dropdown {
            border-color: #777771 !important;
            background-color: #edcbcb !important;
        }

        /* Dropdown items */
        .select2-container--default .select2-results__option {
            color: #000000 !important;
            padding: 8px 12px !important;
        }

        /* Highlighted/hovered item */
        .select2-container--default .select2-results__option--highlighted {
            background-color: #d1d1f1 !important;
            color: #000 !important;
        }

        /* Selected item */
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #4098fd !important;
            color: white !important;
        }

        /* Search box (if enabled) */
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border-color: #777771 !important;
            background-color: #fff !important;
        }
    </style>


    <script>
        flatpickr("#dob", {
            dateFormat: "d-m-Y", // Format like 08-05-2025
            defaultDate: "today",
            maxDate: "today", // Optional: prevent selecting future dates
            allowInput: true
        });
    </script>
    <style>
        .flatpickr-calendar {
            border: 1px solid #00aaff;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .flatpickr-day.today {
            border-color: #00aaff;
        }
        .flatpickr-day.selected {
            background-color: #00aaff;
            color: white;
        }
        .flatpickr-months .flatpickr-month {
            color: #333;
        }
        .flatpickr-monthDropdown-months, .flatpickr-year {
            background: white;
            border: 1px solid #ccc;
        }
    </style>

</head>
<body class="bg-gray-200 p-12">

<meta name="csrf-token" content="{{ csrf_token() }}">


    <form id="admissionForm" class="max-w-6xl mx-auto p-12 space-y-12 bg-white rounded shadow" method="POST">
        <a href="https://mawaridtech.com/" rel="home">
            <img fetchpriority="high" src="https://mawaridtech.com/wp-content/uploads/2024/03/logoweb.png"  alt="Mawarid logo">
        </a><br>

        {{--stepper--}}
        <div class="w-full max-w-3xl mx-auto mt-10">
            <div class="relative w-full">
                <!-- Line -->
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-gray-300 transform -translate-y-1/2"></div>

                <div class="flex justify-between items-center relative z-10">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center step" data-step="1">
                        <div class="w-5 h-5 rounded-full border-2 step-circle"></div>
                        <span class="text-sm mt-1 step-text">Page</span>
                        <span class="text-sm step-text">1</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center step" data-step="2">
                        <div class="w-5 h-5 rounded-full border-2 step-circle"></div>
                        <span class="text-sm mt-1 step-text">Finish</span>
                    </div>
                </div>
            </div>
        </div>



        <h1 class="text-3xl font-bold">ADMISSION FORM</h1>
        <br>

        <div id="step1" style="display: block;">
            <div>
                <h2 class="text-xl font-semibold border-b pb-2 mb-4 forminator-title">PERSONAL INFORMATION</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-1">Full Name <span class="forminator-required">*</span></label>
                        <input type="text" name="name" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. John Doe" required>
                        <span class="forminator-error-message">Name is required.</span>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Email Address <span class="forminator-required">*</span></label>
                        <input type="email" name="email" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. john@doe.com" required>
                        <span class="forminator-error-message">Email is required.</span>

                    </div>

                    <div>
                        <label class="block font-medium mb-1">Gender <span class="forminator-required">*</span></label>
                        <div class="flex space-x-4 mt-2">
                            <label><input type="radio" name="gender" value="Male" required><span></span> <p>Male</p></label>
                            <label><input type="radio" name="gender" value="Female" required><span></span> <p>Female</p></label>
                        </div>
                        <span class="forminator-error-message">Gender is required.</span>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Date of Birth <span class="forminator-required">*</span></label>
                        <input type="date" name="dob" class="w-full border rounded px-3 py-2 forminator-input" required>
{{--                        <input id="dob" name="dob" type="text" placeholder="DD-MM-YYYY" class="form-control" required>--}}
                        <span class="forminator-error-message">Date of Birth is required.</span>

                    </div>

                    <div>
                        <label class="block font-medium mb-1">Phone <span class="forminator-required">*</span></label>
                        <input type="text" name="phone" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. +1 300 400 5000" required>
                        <span class="forminator-error-message">Phone Number is required.</span>

                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-medium mb-1">Street Address <span class="forminator-required">*</span></label>
                        <input type="text" name="street_address" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. 42 Wallaby Way" required>
                        <span class="forminator-error-message">Street Address is required.</span>

                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-medium mb-1">Apartment, suite, etc</label>
                        <input type="text" name="apartment" class="w-full border rounded px-3 py-2 forminator-input">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">City <span class="forminator-required">*</span></label>
                        <input type="text" name="city" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. Sydney" required>
                        <span class="forminator-error-message">City is required.</span>

                    </div>

                    <div>
                        <label class="block font-medium mb-1">State/Province <span class="forminator-required">*</span></label>
                        <input type="text" name="state" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. New South Wales" required>
                        <span class="forminator-error-message">State is required.</span>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">ZIP / Postal Code <span class="forminator-required">*</span></label>
                        <input type="text" name="zip" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. 2000" required>
                        <span class="forminator-error-message">ZIP / Postal Code is required.</span>

                    </div>

                    <div>
                        <label class="block font-medium mb-1">Country <span class="forminator-required">*</span></label>
                        <select name="country" id="country" class="w-full border rounded px-3 py-2 forminator-input" required>
                            <option value="">Select country</option>
                            <option value="af" data-name="Afghanistan">Afghanistan</option>
                            <option value="al" data-name="Albania">Albania</option>
                            <option value="dz" data-name="Algeria">Algeria</option>
                            <option value="ad" data-name="Andorra">Andorra</option>
                            <option value="ao" data-name="Angola">Angola</option>
                            <option value="ag" data-name="Antigua and Barbuda">Antigua and Barbuda</option>
                            <option value="ar" data-name="Argentina">Argentina</option>
                            <option value="am" data-name="Armenia">Armenia</option>
                            <option value="au" data-name="Australia">Australia</option>
                            <option value="at" data-name="Austria">Austria</option>
                            <option value="az" data-name="Azerbaijan">Azerbaijan</option>
                            <option value="bs" data-name="Bahamas">Bahamas</option>
                            <option value="bh" data-name="Bahrain">Bahrain</option>
                            <option value="bd" data-name="Bangladesh">Bangladesh</option>
                            <option value="bb" data-name="Barbados">Barbados</option>
                            <option value="by" data-name="Belarus">Belarus</option>
                            <option value="be" data-name="Belgium">Belgium</option>
                            <option value="bz" data-name="Belize">Belize</option>
                            <option value="bj" data-name="Benin">Benin</option>
                            <option value="bt" data-name="Bhutan">Bhutan</option>
                            <option value="bo" data-name="Bolivia">Bolivia</option>
                            <option value="ba" data-name="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                            <option value="bw" data-name="Botswana">Botswana</option>
                            <option value="br" data-name="Brazil">Brazil</option>
                            <option value="bn" data-name="Brunei">Brunei</option>
                            <option value="bg" data-name="Bulgaria">Bulgaria</option>
                            <option value="bf" data-name="Burkina Faso">Burkina Faso</option>
                            <option value="bi" data-name="Burundi">Burundi</option>
                            <option value="cv" data-name="Cabo Verde">Cabo Verde</option>
                            <option value="kh" data-name="Cambodia" selected>Cambodia</option>
                            <option value="cm" data-name="Cameroon">Cameroon</option>
                            <option value="ca" data-name="Canada">Canada</option>
                            <option value="cf" data-name="Central African Republic">Central African Republic</option>
                            <option value="td" data-name="Chad">Chad</option>
                            <option value="cl" data-name="Chile">Chile</option>
                            <option value="cn" data-name="China">China</option>
                            <option value="co" data-name="Colombia">Colombia</option>
                            <option value="km" data-name="Comoros">Comoros</option>
                            <option value="cg" data-name="Congo (Brazzaville)">Congo (Brazzaville)</option>
                            <option value="cd" data-name="Congo (Kinshasa)">Congo (Kinshasa)</option>
                            <option value="cr" data-name="Costa Rica">Costa Rica</option>
                            <option value="hr" data-name="Croatia">Croatia</option>
                            <option value="cu" data-name="Cuba">Cuba</option>
                            <option value="cy" data-name="Cyprus">Cyprus</option>
                            <option value="cz" data-name="Czech Republic">Czech Republic</option>
                            <option value="dk" data-name="Denmark">Denmark</option>
                            <option value="dj" data-name="Djibouti">Djibouti</option>
                            <option value="dm" data-name="Dominica">Dominica</option>
                            <option value="do" data-name="Dominican Republic">Dominican Republic</option>
                            <option value="ec" data-name="Ecuador">Ecuador</option>
                            <option value="eg" data-name="Egypt">Egypt</option>
                            <option value="sv" data-name="El Salvador">El Salvador</option>
                            <option value="gq" data-name="Equatorial Guinea">Equatorial Guinea</option>
                            <option value="er" data-name="Eritrea">Eritrea</option>
                            <option value="ee" data-name="Estonia">Estonia</option>
                            <option value="sz" data-name="Eswatini">Eswatini</option>
                            <option value="et" data-name="Ethiopia">Ethiopia</option>
                            <option value="fj" data-name="Fiji">Fiji</option>
                            <option value="fi" data-name="Finland">Finland</option>
                            <option value="fr" data-name="France">France</option>
                            <option value="ga" data-name="Gabon">Gabon</option>
                            <option value="gm" data-name="Gambia">Gambia</option>
                            <option value="ge" data-name="Georgia">Georgia</option>
                            <option value="de" data-name="Germany">Germany</option>
                            <option value="gh" data-name="Ghana">Ghana</option>
                            <option value="gr" data-name="Greece">Greece</option>
                            <option value="gd" data-name="Grenada">Grenada</option>
                            <option value="gt" data-name="Guatemala">Guatemala</option>
                            <option value="gn" data-name="Guinea">Guinea</option>
                            <option value="gw" data-name="Guinea-Bissau">Guinea-Bissau</option>
                            <option value="gy" data-name="Guyana">Guyana</option>
                            <option value="ht" data-name="Haiti">Haiti</option>
                            <option value="hn" data-name="Honduras">Honduras</option>
                            <option value="hu" data-name="Hungary">Hungary</option>
                            <option value="is" data-name="Iceland">Iceland</option>
                            <option value="in" data-name="India">India</option>
                            <option value="id" data-name="Indonesia">Indonesia</option>
                            <option value="ir" data-name="Iran">Iran</option>
                            <option value="iq" data-name="Iraq">Iraq</option>
                            <option value="ie" data-name="Ireland">Ireland</option>
                            <option value="il" data-name="Israel">Israel</option>
                            <option value="it" data-name="Italy">Italy</option>
                            <option value="jm" data-name="Jamaica">Jamaica</option>
                            <option value="jp" data-name="Japan">Japan</option>
                            <option value="jo" data-name="Jordan">Jordan</option>
                            <option value="kz" data-name="Kazakhstan">Kazakhstan</option>
                            <option value="ke" data-name="Kenya">Kenya</option>
                            <option value="ki" data-name="Kiribati">Kiribati</option>
                            <option value="kw" data-name="Kuwait">Kuwait</option>
                            <option value="kg" data-name="Kyrgyzstan">Kyrgyzstan</option>
                            <option value="la" data-name="Laos">Laos</option>
                            <option value="lv" data-name="Latvia">Latvia</option>
                            <option value="lb" data-name="Lebanon">Lebanon</option>
                            <option value="ls" data-name="Lesotho">Lesotho</option>
                            <option value="lr" data-name="Liberia">Liberia</option>
                            <option value="ly" data-name="Libya">Libya</option>
                            <option value="li" data-name="Liechtenstein">Liechtenstein</option>
                            <option value="lt" data-name="Lithuania">Lithuania</option>
                            <option value="lu" data-name="Luxembourg">Luxembourg</option>
                            <option value="mg" data-name="Madagascar">Madagascar</option>
                            <option value="mw" data-name="Malawi">Malawi</option>
                            <option value="my" data-name="Malaysia">Malaysia</option>
                            <option value="mv" data-name="Maldives">Maldives</option>
                            <option value="ml" data-name="Mali">Mali</option>
                            <option value="mt" data-name="Malta">Malta</option>
                            <option value="mh" data-name="Marshall Islands">Marshall Islands</option>
                            <option value="mr" data-name="Mauritania">Mauritania</option>
                            <option value="mu" data-name="Mauritius">Mauritius</option>
                            <option value="mx" data-name="Mexico">Mexico</option>
                            <option value="fm" data-name="Micronesia">Micronesia</option>
                            <option value="md" data-name="Moldova">Moldova</option>
                            <option value="mc" data-name="Monaco">Monaco</option>
                            <option value="mn" data-name="Mongolia">Mongolia</option>
                            <option value="me" data-name="Montenegro">Montenegro</option>
                            <option value="ma" data-name="Morocco">Morocco</option>
                            <option value="mz" data-name="Mozambique">Mozambique</option>
                            <option value="mm" data-name="Myanmar">Myanmar</option>
                            <option value="na" data-name="Namibia">Namibia</option>
                            <option value="nr" data-name="Nauru">Nauru</option>
                            <option value="np" data-name="Nepal">Nepal</option>
                            <option value="nl" data-name="Netherlands">Netherlands</option>
                            <option value="nz" data-name="New Zealand">New Zealand</option>
                            <option value="ni" data-name="Nicaragua">Nicaragua</option>
                            <option value="ne" data-name="Niger">Niger</option>
                            <option value="ng" data-name="Nigeria">Nigeria</option>
                            <option value="kp" data-name="North Korea">North Korea</option>
                            <option value="mk" data-name="North Macedonia">North Macedonia</option>
                            <option value="no" data-name="Norway">Norway</option>
                            <option value="om" data-name="Oman">Oman</option>
                            <option value="pk" data-name="Pakistan">Pakistan</option>
                            <option value="pw" data-name="Palau">Palau</option>
                            <option value="ps" data-name="Palestine">Palestine</option>
                            <option value="pa" data-name="Panama">Panama</option>
                            <option value="pg" data-name="Papua New Guinea">Papua New Guinea</option>
                            <option value="py" data-name="Paraguay">Paraguay</option>
                            <option value="pe" data-name="Peru">Peru</option>
                            <option value="ph" data-name="Philippines">Philippines</option>
                            <option value="pl" data-name="Poland">Poland</option>
                            <option value="pt" data-name="Portugal">Portugal</option>
                            <option value="qa" data-name="Qatar">Qatar</option>
                            <option value="ro" data-name="Romania">Romania</option>
                            <option value="ru" data-name="Russia">Russia</option>
                            <option value="rw" data-name="Rwanda">Rwanda</option>
                            <option value="kn" data-name="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                            <option value="lc" data-name="Saint Lucia">Saint Lucia</option>
                            <option value="vc" data-name="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                            <option value="ws" data-name="Samoa">Samoa</option>
                            <option value="sm" data-name="San Marino">San Marino</option>
                            <option value="st" data-name="Sao Tome and Principe">Sao Tome and Principe</option>
                            <option value="sa" data-name="Saudi Arabia">Saudi Arabia</option>
                            <option value="sn" data-name="Senegal">Senegal</option>
                            <option value="rs" data-name="Serbia">Serbia</option>
                            <option value="sc" data-name="Seychelles">Seychelles</option>
                            <option value="sl" data-name="Sierra Leone">Sierra Leone</option>
                            <option value="sg" data-name="Singapore">Singapore</option>
                            <option value="sk" data-name="Slovakia">Slovakia</option>
                            <option value="si" data-name="Slovenia">Slovenia</option>
                            <option value="sb" data-name="Solomon Islands">Solomon Islands</option>
                            <option value="so" data-name="Somalia">Somalia</option>
                            <option value="za" data-name="South Africa">South Africa</option>
                            <option value="kr" data-name="South Korea">South Korea</option>
                            <option value="ss" data-name="South Sudan">South Sudan</option>
                            <option value="es" data-name="Spain">Spain</option>
                            <option value="lk" data-name="Sri Lanka">Sri Lanka</option>
                            <option value="sd" data-name="Sudan">Sudan</option>
                            <option value="sr" data-name="Suriname">Suriname</option>
                            <option value="se" data-name="Sweden">Sweden</option>
                            <option value="ch" data-name="Switzerland">Switzerland</option>
                            <option value="sy" data-name="Syria">Syria</option>
                            <option value="tw" data-name="Taiwan">Taiwan</option>
                            <option value="tj" data-name="Tajikistan">Tajikistan</option>
                            <option value="tz" data-name="Tanzania">Tanzania</option>
                            <option value="th" data-name="Thailand">Thailand</option>
                            <option value="tl" data-name="Timor-Leste">Timor-Leste</option>
                            <option value="tg" data-name="Togo">Togo</option>
                            <option value="to" data-name="Tonga">Tonga</option>
                            <option value="tt" data-name="Trinidad and Tobago">Trinidad and Tobago</option>
                            <option value="tn" data-name="Tunisia">Tunisia</option>
                            <option value="tr" data-name="Turkey">Turkey</option>
                            <option value="tm" data-name="Turkmenistan">Turkmenistan</option>
                            <option value="tv" data-name="Tuvalu">Tuvalu</option>
                            <option value="ug" data-name="Uganda">Uganda</option>
                            <option value="ua" data-name="Ukraine">Ukraine</option>
                            <option value="ae" data-name="United Arab Emirates">United Arab Emirates</option>
                            <option value="gb" data-name="United Kingdom">United Kingdom</option>
                            <option value="us" data-name="United States">United States</option>
                            <option value="uy" data-name="Uruguay">Uruguay</option>
                            <option value="uz" data-name="Uzbekistan">Uzbekistan</option>
                            <option value="vu" data-name="Vanuatu">Vanuatu</option>
                            <option value="va" data-name="Vatican City">Vatican City</option>
                            <option value="ve" data-name="Venezuela">Venezuela</option>
                            <option value="vn" data-name="Vietnam">Vietnam</option>
                            <option value="ye" data-name="Yemen">Yemen</option>
                            <option value="zm" data-name="Zambia">Zambia</option>
                            <option value="zw" data-name="Zimbabwe">Zimbabwe</option>
                        </select>


                    </div>
                </div>
            </div>
            <br>
            <div>
                <h2 class="text-xl font-semibold border-b pb-2 mb-4 forminator-title">COURSE APPLYING FOR</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium mb-1">Courses <span class="forminator-required">*</span></label>
                        <div class="space-y-2">
                            <label><input type="checkbox" name="courses[]" value="6 Weeks Course"><span></span> <p>6 Weeks Course</p>
                            </label><br>
                            <label><input type="checkbox" name="courses[]" value="Short Courses 6 Months"><span></span><p>Short Courses 6 Months</p>
                            </label><br>
                            <label><input type="checkbox" name="courses[]" value="Diploma 1 Year"><span></span><p>Diploma 1 Year</p>
                            </label><br>
                            <label><input type="checkbox" name="courses[]" value="Associate Degree"><span></span><p>Associate Degree</p>
                            </label>
                        </div>
                        <span class="forminator-error-message text-red-500 text-sm mt-1" id="courses-error">Select at least one course.</span>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Mode of Study <span class="forminator-required">*</span></label>
                        <div class="flex space-x-4">
                            <label><input type="radio" name="mode" value="Full time" required><span></span><p>Full time</p></label>
                            <label><input type="radio" name="mode" value="Weekend" required><span></span><p>Weekend</p></label>
                        </div>
                        <span class="forminator-error-message">Mode of Study is required.</span>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-medium mb-1">Subject <span class="forminator-required">*</span></label>
                        <input type="text" name="subject" class="w-full border rounded px-3 py-2 forminator-input" placeholder="e.g. Graphic Design, Web Design" required>
                        <span class="forminator-error-message">Subject is required.</span>
                    </div>
                </div>
            </div>
            <br>
            <div class="text-right">
                <button type="button" id="nextBtn" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded">Next</button>
            </div>
        </div>

        <!-- STEP 2: Form Section (should be hidden initially if multi-step) -->
        <div id="step2" style="display: none;" class="max-w-6xl mx-auto p-6 space-y-6 bg-white">
            <h2 class="text-xl font-semibold border-b pb-2 mb-4 forminator-title">EDUCATIONAL BACKGROUND</h2>
            <label class="block font-medium mb-5">Educational Background <span class="forminator-required">*</span></label>

            <div class="space-y-2">
                <div class="flex flex-wrap gap-4">
                    <label><input type="checkbox" name="education[]" value="High School"><span></span><p>High School</p></label>
                    <label><input type="checkbox" name="education[]" value="Diploma"><span></span><p>Diploma</p></label>
                    <label><input type="checkbox" name="education[]" value="Associate Degree"><span></span> <p>Associate Degree</p></label>
                    <label><input type="checkbox" name="education[]" value="Bachelors Degree"><span></span><p>Bachelors Degree</p></label>
                </div>
                <span class="forminator-error-message" id="education-error">Select at least one education.</span>
            </div>

            <h2 class="text-xl font-semibold border-b pb-2 mt-6 forminator-title">WORK EXPERIENCE</h2>
            <input type="text" name="work_exp" class="w-full border rounded px-3 py-2 forminator-input" placeholder="e.g. Graphic Designer, Web Developer">

            <h2 class="text-xl font-semibold border-b pb-2 mt-6 forminator-title">GUARDIAN CONTACT</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Name </label>
                    <input type="text" name="guardian_name" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. John Doe">
                </div>

                <div>
                    <label class="block font-medium mb-1">Relationship</label>
                    <input type="text" name="guardian_relationship" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. Father / mother">
                </div>

                <div>
                    <label class="block font-medium mb-1">Email Address </label>
                    <input type="email" name="guardian_email" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. john@doe.com" >
                </div>

                <div>
                    <label class="block font-medium mb-1">Phone <span class="forminator-required"></span></label>
                    <input type="text" name="guardian_phone" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. +1 300 400 5000" >
                </div>
            </div>

            <h2 class="text-xl font-semibold border-b pb-2 mt-6 forminator-title">TERMS & CONDITIONS</h2>

            <div class="space-y-4">
                <label class="block font-medium mb-5">Consent <span class="forminator-required">*</span></label>
                <label class="flex items-start gap-2">
                    <input type="checkbox" name="consent" id="consentCheckbox" required><span style="width: 30px"></span>
                    <label class="text-sm">
                        I, the undersigned, certify that all information provided in this form is accurate to the best of my knowledge.
                        I agree to follow the academy's rules, regulations, and code of conduct.
                        I understand that failure to adhere to the terms may result in the termination of my enrollment.
                    </label>
                </label>

                <ul class="list-disc ml-6 text-sm text-gray-600">
                    <li><strong>Refund Policy:</strong> The course fee is non-refundable after the course has commenced.</li>
                    <li><strong>Attendance Requirement:</strong> A minimum of 80% attendance is required to complete the course successfully.</li>
                    <li><strong>Code of Conduct:</strong> Students are expected to maintain respectful and professional behaviour at all times.</li>
                </ul>
                <span class="forminator-error-message" id="consent-error">Please agree to the terms & conditions.</span>

                <div>
                    <label class="block font-medium mb-4 mt-4">Reference</label>
                    <input type="text" name="reference" class="w-full border rounded px-3 py-2 forminator-input" placeholder="E.g. John Doe">
                </div>
            </div>

            <!-- Form Navigation -->
            <div class="flex justify-between mt-6">
                <button type="button" id="prevBtn" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-6 rounded">Previous</button>
                <button type="submit" id="submitBtn" class="bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2 px-6 rounded">Submit Application</button>
            </div>
        </div>

    </form>



<script>
    // Initialize stepper and form navigation
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize stepper
        updateStepper();

        // Initialize form steps
        document.getElementById('step2').style.display = 'none';

        // Initialize Select2 for country dropdown
        $('#country').select2({
            templateResult: formatCountry,
            templateSelection: formatCountry,
            placeholder: "Select country",
            width: 'resolve'
        });

        // Initialize flatpickr for date input
        flatpickr("#dob", {
            dateFormat: "d-m-Y",
            defaultDate: "today",
            maxDate: "today",
            allowInput: true
        });
    });

    // Format country dropdown with flags
    function formatCountry(country) {
        if (!country.id) return country.text;
        const code = country.id.toLowerCase();
        const flagUrl = `https://flagcdn.com/w40/${code}.png`;
        const name = $(country.element).data('name') || country.text;
        return $(`
            <span>
                <img src="${flagUrl}" class="inline-block mr-2" width="16" height="12" />
                ${name}
            </span>
        `);
    }

    // Update stepper UI based on current step
    function updateStepper() {
        const step1 = document.getElementById('step1');
        const currentStep = (step1 && getComputedStyle(step1).display === "none") ? 2 : 1;

        document.querySelectorAll('.step').forEach(step => {
            const stepNumber = parseInt(step.getAttribute('data-step'));
            const circle = step.querySelector('.step-circle');
            const texts = step.querySelectorAll('.step-text');

            if (stepNumber <= currentStep) {
                // Active step styling
                circle.classList.add('bg-blue-500', 'border-blue-500');
                circle.classList.remove('bg-gray-500', 'border-gray-500');
                texts.forEach(text => {
                    text.classList.add('text-blue-500');
                    text.classList.remove('text-gray-500');
                });
            } else {
                // Inactive step styling
                circle.classList.remove('bg-blue-500', 'border-blue-500');
                circle.classList.add('bg-gray-500', 'border-gray-500');
                texts.forEach(text => {
                    text.classList.remove('text-blue-500');
                    text.classList.add('text-gray-500');
                });
            }
        });
    }

    // Next button click handler
    document.getElementById('nextBtn')?.addEventListener('click', function() {
        if (validateStep1()) {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
            updateStepper();
        }
    });

    // Previous button click handler
    document.getElementById('prevBtn')?.addEventListener('click', function() {
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step1').style.display = 'block';
        updateStepper();
    });

    // Validate Step 1 fields
    function validateStep1() {
        let isValid = true;
        const step1 = document.getElementById('step1');

        // Validate required inputs
        step1.querySelectorAll('input[required], select[required]').forEach(input => {
            const errorMessage = input.closest('div').querySelector('.forminator-error-message');

            const radioGroupsChecked = new Set();
            // Radio group validation
            if (input.type === "radio") {
                if (radioGroupsChecked.has(input.name)) return;

                const groupChecked = step1.querySelector(`input[name="${input.name}"]:checked`);
                const wrapperDiv = input.closest("div")?.parentElement;
                const groupError = wrapperDiv?.querySelector(".forminator-error-message");

                if (!groupChecked) {
                    isValid = false;
                    // if (wrapperDiv) wrapperDiv.classList.add("border-red-500");
                    if (groupError) groupError.style.display = "block";
                } else {
                    // if (wrapperDiv) wrapperDiv.classList.remove("border-red-500");
                    if (groupError) groupError.style.display = "none";
                }

                radioGroupsChecked.add(input.name);
            }
            else if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500');
                if (errorMessage) errorMessage.style.display = 'block';
            } else {
                input.classList.remove('border-red-500');
                if (errorMessage) errorMessage.style.display = 'none';
            }
        });

        // Validate courses checkbox group
        const courseCheckboxes = step1.querySelectorAll('input[name="courses[]"]');
        const isCourseSelected = Array.from(courseCheckboxes).some(cb => cb.checked);
        const courseError = document.getElementById('courses-error');

        if (!isCourseSelected) {
            isValid = false;
            courseCheckboxes.forEach(cb => cb.classList.add('outline', 'outline-red-500'));
            if (courseError) courseError.style.display = 'block';
        } else {
            courseCheckboxes.forEach(cb => cb.classList.remove('outline', 'outline-red-500'));
            if (courseError) courseError.style.display = 'none';
        }

        if (!isValid) {
            alert('Please complete all required fields in Step 1.');
        }

        return isValid;
    }

    // Form submission handler
    document.getElementById('admissionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!validateStep2()) return;

        const formData = new FormData(this);
        const submitUrl = "{{ route('studentsAdmission.store') }}";

        fetch(submitUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                alert('Form submitted successfully!');
                this.reset();
                // Optionally redirect to a thank you page
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error submitting the form.');
            });
    });

    // Validate Step 2 fields
    function validateStep2() {
        let isValid = true;
        const step2 = document.getElementById('step2');

        // Validate education checkboxes
        const educationBoxes = step2.querySelectorAll('input[name="education[]"]');
        const isEducationChecked = Array.from(educationBoxes).some(cb => cb.checked);
        const educationError = document.getElementById('education-error');

        if (!isEducationChecked) {
            isValid = false;
            educationBoxes.forEach(cb => cb.classList.add('outline', 'outline-red-500'));
            educationError.style.display = 'block';
        } else {
            educationBoxes.forEach(cb => cb.classList.remove('outline', 'outline-red-500'));
            educationError.style.display = 'none';
        }

        // Validate consent checkbox
        const consentCheckbox = document.getElementById('consentCheckbox');
        const consentError = document.getElementById('consent-error');

        if (!consentCheckbox.checked) {
            isValid = false;
            consentCheckbox.classList.add('outline', 'outline-red-500');
            consentError.style.display = 'block';
        } else {
            consentCheckbox.classList.remove('outline', 'outline-red-500');
            consentError.style.display = 'none';
        }

        if (!isValid) {
            alert('Please complete all required fields in Step 2.');
        }

        return isValid;
    }
</script>





</body>
</html>



