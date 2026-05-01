@extends('layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3>Student Admission List</h3>
            </div>
        </div>

        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th class="sorting" tabindex="0" width="50px" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">#</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Email</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Phone</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">City</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Country</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Course</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Date</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Status</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($admissions as $index => $admission)
                                <tr data-href="{{ route('studentsAdmission.show', $admission->id) }}" style="cursor: pointer">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $admission->full_name }}</td>
                                    <td>{{ $admission->email }}</td>
                                    <td>{{ $admission->phone }}</td>
                                    <td>{{ $admission->city }}</td>
{{--                                    <td>{{ $admission->country }}</td>--}}
                                    @php
                                        $countries = [
                                            'AF' => 'Afghanistan',
                                            'AL' => 'Albania',
                                            'DZ' => 'Algeria',
                                            'AS' => 'American Samoa',
                                            'AD' => 'Andorra',
                                            'AO' => 'Angola',
                                            'AI' => 'Anguilla',
                                            'AQ' => 'Antarctica',
                                            'AG' => 'Antigua and Barbuda',
                                            'AR' => 'Argentina',
                                            'AM' => 'Armenia',
                                            'AW' => 'Aruba',
                                            'AU' => 'Australia',
                                            'AT' => 'Austria',
                                            'AZ' => 'Azerbaijan',
                                            'BS' => 'Bahamas',
                                            'BH' => 'Bahrain',
                                            'BD' => 'Bangladesh',
                                            'BB' => 'Barbados',
                                            'BY' => 'Belarus',
                                            'BE' => 'Belgium',
                                            'BZ' => 'Belize',
                                            'BJ' => 'Benin',
                                            'BM' => 'Bermuda',
                                            'BT' => 'Bhutan',
                                            'BO' => 'Bolivia',
                                            'BA' => 'Bosnia and Herzegovina',
                                            'BW' => 'Botswana',
                                            'BR' => 'Brazil',
                                            'BN' => 'Brunei Darussalam',
                                            'BG' => 'Bulgaria',
                                            'BF' => 'Burkina Faso',
                                            'BI' => 'Burundi',
                                            'KH' => 'Cambodia',
                                            'CM' => 'Cameroon',
                                            'CA' => 'Canada',
                                            'CV' => 'Cape Verde',
                                            'CF' => 'Central African Republic',
                                            'TD' => 'Chad',
                                            'CL' => 'Chile',
                                            'CN' => 'China',
                                            'CO' => 'Colombia',
                                            'KM' => 'Comoros',
                                            'CG' => 'Congo',
                                            'CD' => 'Congo, the Democratic Republic of the',
                                            'CR' => 'Costa Rica',
                                            'CI' => "Côte d'Ivoire",
                                            'HR' => 'Croatia',
                                            'CU' => 'Cuba',
                                            'CY' => 'Cyprus',
                                            'CZ' => 'Czech Republic',
                                            'DK' => 'Denmark',
                                            'DJ' => 'Djibouti',
                                            'DM' => 'Dominica',
                                            'DO' => 'Dominican Republic',
                                            'EC' => 'Ecuador',
                                            'EG' => 'Egypt',
                                            'SV' => 'El Salvador',
                                            'GQ' => 'Equatorial Guinea',
                                            'ER' => 'Eritrea',
                                            'EE' => 'Estonia',
                                            'ET' => 'Ethiopia',
                                            'FJ' => 'Fiji',
                                            'FI' => 'Finland',
                                            'FR' => 'France',
                                            'GA' => 'Gabon',
                                            'GM' => 'Gambia',
                                            'GE' => 'Georgia',
                                            'DE' => 'Germany',
                                            'GH' => 'Ghana',
                                            'GR' => 'Greece',
                                            'GD' => 'Grenada',
                                            'GT' => 'Guatemala',
                                            'GN' => 'Guinea',
                                            'GW' => 'Guinea-Bissau',
                                            'GY' => 'Guyana',
                                            'HT' => 'Haiti',
                                            'HN' => 'Honduras',
                                            'HU' => 'Hungary',
                                            'IS' => 'Iceland',
                                            'IN' => 'India',
                                            'ID' => 'Indonesia',
                                            'IR' => 'Iran (Islamic Republic of)',
                                            'IQ' => 'Iraq',
                                            'IE' => 'Ireland',
                                            'IL' => 'Israel',
                                            'IT' => 'Italy',
                                            'JM' => 'Jamaica',
                                            'JP' => 'Japan',
                                            'JO' => 'Jordan',
                                            'KZ' => 'Kazakhstan',
                                            'KE' => 'Kenya',
                                            'KI' => 'Kiribati',
                                            'KP' => "Korea (Democratic People's Republic of)",
                                            'KR' => 'Korea, Republic of',
                                            'KW' => 'Kuwait',
                                            'KG' => 'Kyrgyzstan',
                                            'LA' => "Lao People's Democratic Republic",
                                            'LV' => 'Latvia',
                                            'LB' => 'Lebanon',
                                            'LS' => 'Lesotho',
                                            'LR' => 'Liberia',
                                            'LY' => 'Libya',
                                            'LI' => 'Liechtenstein',
                                            'LT' => 'Lithuania',
                                            'LU' => 'Luxembourg',
                                            'MG' => 'Madagascar',
                                            'MW' => 'Malawi',
                                            'MY' => 'Malaysia',
                                            'MV' => 'Maldives',
                                            'ML' => 'Mali',
                                            'MT' => 'Malta',
                                            'MH' => 'Marshall Islands',
                                            'MR' => 'Mauritania',
                                            'MU' => 'Mauritius',
                                            'MX' => 'Mexico',
                                            'FM' => 'Micronesia (Federated States of)',
                                            'MD' => 'Moldova (Republic of)',
                                            'MC' => 'Monaco',
                                            'MN' => 'Mongolia',
                                            'ME' => 'Montenegro',
                                            'MA' => 'Morocco',
                                            'MZ' => 'Mozambique',
                                            'MM' => 'Myanmar',
                                            'NA' => 'Namibia',
                                            'NR' => 'Nauru',
                                            'NP' => 'Nepal',
                                            'NL' => 'Netherlands',
                                            'NZ' => 'New Zealand',
                                            'NI' => 'Nicaragua',
                                            'NE' => 'Niger',
                                            'NG' => 'Nigeria',
                                            'NO' => 'Norway',
                                            'OM' => 'Oman',
                                            'PK' => 'Pakistan',
                                            'PW' => 'Palau',
                                            'PA' => 'Panama',
                                            'PG' => 'Papua New Guinea',
                                            'PY' => 'Paraguay',
                                            'PE' => 'Peru',
                                            'PH' => 'Philippines',
                                            'PL' => 'Poland',
                                            'PT' => 'Portugal',
                                            'QA' => 'Qatar',
                                            'RO' => 'Romania',
                                            'RU' => 'Russian Federation',
                                            'RW' => 'Rwanda',
                                            'KN' => 'Saint Kitts and Nevis',
                                            'LC' => 'Saint Lucia',
                                            'VC' => 'Saint Vincent and the Grenadines',
                                            'WS' => 'Samoa',
                                            'SM' => 'San Marino',
                                            'ST' => 'Sao Tome and Principe',
                                            'SA' => 'Saudi Arabia',
                                            'SN' => 'Senegal',
                                            'RS' => 'Serbia',
                                            'SC' => 'Seychelles',
                                            'SL' => 'Sierra Leone',
                                            'SG' => 'Singapore',
                                            'SK' => 'Slovakia',
                                            'SI' => 'Slovenia',
                                            'SB' => 'Solomon Islands',
                                            'SO' => 'Somalia',
                                            'ZA' => 'South Africa',
                                            'SS' => 'South Sudan',
                                            'ES' => 'Spain',
                                            'LK' => 'Sri Lanka',
                                            'SD' => 'Sudan',
                                            'SR' => 'Suriname',
                                            'SE' => 'Sweden',
                                            'CH' => 'Switzerland',
                                            'SY' => 'Syrian Arab Republic',
                                            'TW' => 'Taiwan, Province of China',
                                            'TJ' => 'Tajikistan',
                                            'TZ' => 'Tanzania, United Republic of',
                                            'TH' => 'Thailand',
                                            'TL' => 'Timor-Leste',
                                            'TG' => 'Togo',
                                            'TO' => 'Tonga',
                                            'TT' => 'Trinidad and Tobago',
                                            'TN' => 'Tunisia',
                                            'TR' => 'Turkey',
                                            'TM' => 'Turkmenistan',
                                            'TV' => 'Tuvalu',
                                            'UG' => 'Uganda',
                                            'UA' => 'Ukraine',
                                            'AE' => 'United Arab Emirates',
                                            'GB' => 'United Kingdom',
                                            'US' => 'United States of America',
                                            'UY' => 'Uruguay',
                                            'UZ' => 'Uzbekistan',
                                            'VU' => 'Vanuatu',
                                            'VE' => 'Venezuela (Bolivarian Republic of)',
                                            'VN' => 'Viet Nam',
                                            'YE' => 'Yemen',
                                            'ZM' => 'Zambia',
                                            'ZW' => 'Zimbabwe'
                                        ];

                                        $code = strtolower($admission->country);
                                        $name = strtoupper($countries[$code] ?? $admission->country);
                                    @endphp

                                    <td>
                                        <img src="https://flagcdn.com/24x18/{{ $code }}.png" width="24" height="18" class="inline-block mr-2" alt="flag">
                                        {{ $countries[$name] ?? $admission->country }}
                                    </td>
                                    <td>{{ $admission->course }}</td>
                                    <td>{{ \Carbon\Carbon::parse($admission->created_at)->format('d M Y') }}</td>
                                    <td>
                                        @if(Auth::user()->role == 0 && $admission->status == 'pending')
                                            <button class="btn btn-success btn-sm approve-btn" data-id="{{ $admission->id  }}"><i class="fas fa-check"></i> Approve</button> |
                                            <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $admission->id  }}"><i class="fas fa-times"></i> Reject</button>
                                        @elseif($admission->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($admission->status == 'rejected')
                                            <span class="badge bg-danger resizable-span">Rejected</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- View Request Button -->
                                        <a href="{{ route('studentsAdmission.show', $admission->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
|
                                        <form action="{{ route('admissions.destroy', $admission->id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm text-white delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="border px-4 py-4 text-center text-gray-500">No admissions found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll("tr[data-href]").forEach(row => {
                row.addEventListener("click", function () {
                    window.location.href = this.dataset.href;
                });
            });
        });
    </script>
    <script>
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function () {
                let id = this.getAttribute('data-id');

                if (confirm("Are you sure you want to approve this admissions?")) {
                    fetch(`/admissions/${id}/approve`, {
                        method: 'PUT',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.success);
                            location.reload();
                        })
                        .catch(error => console.error('Error approving:', error));
                }
            });
        });

        document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', function () {
                let id = this.getAttribute('data-id');

                if (confirm("Are you sure you want to reject this admissions?")) {
                    fetch(`/admissions/${id}/reject`, {
                        method: 'PUT',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                    })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.success);
                            location.reload();
                        })
                        .catch(error => console.error('Error rejecting:', error));
                }
            });
        });
    </script>

@endsection
