@component('mail::message')

<p style="text-align: center;"><img src="{{ asset('img/logo_large.gif') }}" alt="{{ config('app.name') }} Logo" style="width: 350px;margin:0;padding:0;padding-top:10px;"></p>

# One Of Your Clients Has Finished An Upload

Client Name: {{ $client_name }}<br>
Upload Name: {{ $upload_name }}<br>
Date and Time of Upload: {{ $date_time_of_upload }}<br>
Number of Files: {{ $number_of_files }}

@component('mail::button', ['url' => 'https://secureportal.acountinghouse.com/'])
Click here to login and download the files
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
