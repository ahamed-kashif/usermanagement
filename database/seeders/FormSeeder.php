<?php

namespace Database\Seeders;

use App\Models\FormResponse;
use App\Models\ResponseViewUrl;
use Illuminate\Database\Seeder;
use App\Models\Form;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Rental Application Form details
        Form::create([
            'name' => 'Rental Application Form',
            'fields' => json_encode([
                [
                    'label' => 'First Name',
                    'type' => 'text',
                    'name' => 'first_name',
                    'required' => true,
                    'col_size' => 6
                ],
                [
                    'label' => 'Last Name',
                    'type' => 'text',
                    'name' => 'last_name',
                    'required' => true,
                    'col_size' => 6
                ],
                [
                    'label' => 'Date of Birth',
                    'type' => 'date',
                    'name' => 'date_of_birth',
                    'required' => true,
                    'col_size' => 6
                ],
                [
                    'label' => 'Sex',
                    'type' => 'select',
                    'name' => 'gender',
                    'required' => false,
                    'options' => ['Male', 'Female', 'Others'],
                    'col_size' => 6
                ],
                [
                    'label' => 'Email',
                    'type' => 'email',
                    'name' => 'email',
                    'required' => true,
                    'col_size' => 6
                ],
                [
                    'label' => 'Phone Number',
                    'type' => 'tel',
                    'name' => 'phone_number',
                    'required' => true,
                    'col_size' => 6
                ],
                [
                    'label' => 'Current Address',
                    'type' => 'group',
                    'name' => 'current_address',
                    'fields' => [
                        [
                            'label' => 'Street',
                            'type' => 'text',
                            'name' => 'street',
                            'required' => true,
                            'col_size' => 12
                        ],
                        [
                            'label' => 'City',
                            'type' => 'text',
                            'name' => 'city',
                            'required' => true,
                            'col_size' => 12
                        ],
                        [
                            'label' => 'State',
                            'type' => 'text',
                            'name' => 'state',
                            'required' => true,
                            'col_size' => 6
                        ],
                        [
                            'label' => 'ZIP Code',
                            'type' => 'text',
                            'name' => 'zip_code',
                            'required' => true,
                            'col_size' => 6
                        ],
                        [
                            'label' => 'Country',
                            'type' => 'select',
                            'name' => 'country',
                            'required' => true,
                            'options' => [
                                'Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla',
                                'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan',
                                'The Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize',
                                'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil',
                                'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada',
                                'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China',
                                'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo', 'Cook Islands',
                                'Costa Rica', 'Cote d\'Ivoire', 'Croatia', 'Cuba', 'Curaçao', 'Cyprus', 'Czech Republic',
                                'Democratic Republic of the Congo', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic',
                                'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia',
                                'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Polynesia', 'Gabon',
                                'The Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada',
                                'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti',
                                'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq',
                                'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya',
                                'Kiribati', 'North Korea', 'South Korea', 'Kosovo', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia',
                                'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau',
                                'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands',
                                'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia', 'Moldova', 'Monaco',
                                'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar', 'Nagorno-Karabakh',
                                'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand',
                                'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Turkish Republic of Northern Cyprus',
                                'Northern Mariana', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine', 'Panama', 'Papua New Guinea',
                                'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar',
                                'Republic of the Congo', 'Romania', 'Russia', 'Rwanda', 'Saint Barthelemy', 'Saint Helena',
                                'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin', 'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines',
                                'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles',
                                'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'Somaliland',
                                'South Africa', 'South Ossetia', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname',
                                'Svalbard', 'eSwatini', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania',
                                'Thailand', 'Timor-Leste', 'Togo', 'Tokelau', 'Tonga', 'Transnistria Pridnestrovie', 'Trinidad and Tobago',
                                'Tristan da Cunha', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu',
                                'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay',
                                'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam', 'British Virgin Islands',
                                'Isle of Man', 'US Virgin Islands', 'Wallis and Futuna', 'Western Sahara', 'Yemen', 'Zambia',
                                'Zimbabwe', 'Other'
                            ],
                            'col_size' => 12
                        ],
                    ],
                ],
                [
                    'label' => 'Are you currently employed?',
                    'type' => 'radio',
                    'name' => 'currently_employed',
                    'required' => true,
                    'options' => ['Yes', 'No'],
                    'col_size' => 6
                ],
                [
                    'label' => 'Current Employer',
                    'type' => 'text',
                    'name' => 'current_employer',
                    'required' => false,
                    'col_size' => 6
                ],
                [
                    'label' => 'Monthly Salary (USD)',
                    'type' => 'text',
                    'name' => 'monthly_salary',
                    'required' => false,
                    'col_size' => 12
                ],
                [
                    'label' => 'Address od Residence',
                    'type' => 'group',
                    'name' => 'permanent_address',
                    'fields' => [
                        [
                            'label' => 'Street',
                            'type' => 'text',
                            'name' => 'street',
                            'required' => true,
                            'col_size' => 12
                        ],
                        [
                            'label' => 'City',
                            'type' => 'text',
                            'name' => 'city',
                            'required' => true,
                            'col_size' => 12
                        ],
                        [
                            'label' => 'State',
                            'type' => 'text',
                            'name' => 'state',
                            'required' => true,
                            'col_size' => 6
                        ],
                        [
                            'label' => 'ZIP Code',
                            'type' => 'text',
                            'name' => 'zip_code',
                            'required' => true,
                            'col_size' => 6
                        ],
                        [
                            'label' => 'Country',
                            'type' => 'select',
                            'name' => 'country',
                            'required' => true,
                            'options' => [
                                'Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla',
                                'Antigua and Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan',
                                'The Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize',
                                'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bosnia and Herzegovina', 'Botswana', 'Brazil',
                                'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada',
                                'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Chile', 'China',
                                'Christmas Island', 'Cocos (Keeling) Islands', 'Colombia', 'Comoros', 'Congo', 'Cook Islands',
                                'Costa Rica', 'Cote d\'Ivoire', 'Croatia', 'Cuba', 'Curaçao', 'Cyprus', 'Czech Republic',
                                'Democratic Republic of the Congo', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic',
                                'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia',
                                'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Polynesia', 'Gabon',
                                'The Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Greece', 'Greenland', 'Grenada',
                                'Guadeloupe', 'Guam', 'Guatemala', 'Guernsey', 'Guinea', 'Guinea-Bissau', 'Guyana', 'Haiti',
                                'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'India', 'Indonesia', 'Iran', 'Iraq',
                                'Ireland', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jersey', 'Jordan', 'Kazakhstan', 'Kenya',
                                'Kiribati', 'North Korea', 'South Korea', 'Kosovo', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia',
                                'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau',
                                'Macedonia', 'Madagascar', 'Malawi', 'Malaysia', 'Maldives', 'Mali', 'Malta', 'Marshall Islands',
                                'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Micronesia', 'Moldova', 'Monaco',
                                'Mongolia', 'Montenegro', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar', 'Nagorno-Karabakh',
                                'Namibia', 'Nauru', 'Nepal', 'Netherlands', 'Netherlands Antilles', 'New Caledonia', 'New Zealand',
                                'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Turkish Republic of Northern Cyprus',
                                'Northern Mariana', 'Norway', 'Oman', 'Pakistan', 'Palau', 'Palestine', 'Panama', 'Papua New Guinea',
                                'Paraguay', 'Peru', 'Philippines', 'Pitcairn Islands', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar',
                                'Republic of the Congo', 'Romania', 'Russia', 'Rwanda', 'Saint Barthelemy', 'Saint Helena',
                                'Saint Kitts and Nevis', 'Saint Lucia', 'Saint Martin', 'Saint Pierre and Miquelon', 'Saint Vincent and the Grenadines',
                                'Samoa', 'San Marino', 'Sao Tome and Principe', 'Saudi Arabia', 'Senegal', 'Serbia', 'Seychelles',
                                'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'Somaliland',
                                'South Africa', 'South Ossetia', 'South Sudan', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname',
                                'Svalbard', 'eSwatini', 'Sweden', 'Switzerland', 'Syria', 'Taiwan', 'Tajikistan', 'Tanzania',
                                'Thailand', 'Timor-Leste', 'Togo', 'Tokelau', 'Tonga', 'Transnistria Pridnestrovie', 'Trinidad and Tobago',
                                'Tristan da Cunha', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks and Caicos Islands', 'Tuvalu',
                                'Uganda', 'Ukraine', 'United Arab Emirates', 'United Kingdom', 'United States', 'Uruguay',
                                'Uzbekistan', 'Vanuatu', 'Vatican City', 'Venezuela', 'Vietnam', 'British Virgin Islands',
                                'Isle of Man', 'US Virgin Islands', 'Wallis and Futuna', 'Western Sahara', 'Yemen', 'Zambia',
                                'Zimbabwe', 'Other'
                            ],
                            'col_size' => 12
                        ]
                    ],
                ],
                [
                    'label' => 'Preferred Move-In Date',
                    'type' => 'date',
                    'name' => 'preferred_move_in_date',
                    'required' => false,
                    'col_size' => 6
                ],
                [
                    'label' => 'Appointment',
                    'type' => 'date',
                    'name' => 'appointment',
                    'required' => false,
                    'col_size' => 6
                ],
                [
                    'label' => 'Do you have pets?',
                    'type' => 'radio',
                    'name' => 'have_pets',
                    'required' => false,
                    'options' => ['Yes', 'No'],
                    'col_size' => 6
                ],
                [
                    'label' => 'Have you ever been evicted?',
                    'type' => 'radio',
                    'name' => 'been_evicted',
                    'required' => false,
                    'options' => ['Yes', 'No'],
                    'col_size' => 6
                ],
                [
                    'label' => 'Have you ever been convicted of a felony?',
                    'type' => 'radio',
                    'name' => 'convicted_felony',
                    'required' => false,
                    'options' => ['Yes', 'No'],
                    'col_size' => 12
                ],
                [
                    'label' => 'Have you ever declared bankruptcy?',
                    'type' => 'radio',
                    'name' => 'declared_bankruptcy',
                    'required' => false,
                    'options' => ['Yes', 'No'],
                    'col_size' => 12
                ]
            ]),
        ]);
        Form::create([
            'name' => 'Job Application Form',
            'fields' => json_encode([
                [
                    'label' => 'First Name',
                    'type' => 'text',
                    'name' => 'first_name',
                    'required' => true,
                    'col_size' => 6
                ],
                [
                    'label' => 'Last Name',
                    'type' => 'text',
                    'name' => 'last_name',
                    'required' => true,
                    'col_size' => 6
                ],
                [
                    'label' => 'Email',
                    'type' => 'email',
                    'name' => 'email',
                    'required' => true,
                    'col_size' => 6
                ],
                [
                    'label' => 'Phone Number',
                    'type' => 'tel',
                    'name' => 'phone_number',
                    'required' => true,
                    'col_size' => 6
                ],
                [
                    'label' => 'What position are you applying for?',
                    'type' => 'text',
                    'name' => 'position_applied_for',
                    'required' => true,
                    'col_size' => 12
                ],
                [
                    'label' => 'What is your current employment status?',
                    'type' => 'radio',
                    'name' => 'current_employment_status',
                    'required' => true,
                    'options' => [
                        'Employed Full-Time',
                        'Employed Part-Time',
                        'Self-Employed',
                        'Unemployed',
                        'Student',
                        'Other'
                    ],
                    'col_size' => 12
                ],
                [
                    'label' => 'How do you prefer to submit your resume?',
                    'type' => 'radio',
                    'name' => 'resume_submission_preference',
                    'required' => true,
                    'options' => [
                        'Upload',
                        'Email',
                        'In-Person'
                    ],
                    'col_size' => 12
                ]
            ]),
        ]);
    }
}
