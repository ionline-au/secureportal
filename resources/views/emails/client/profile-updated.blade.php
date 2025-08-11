@component('mail::message')

<p style="text-align: center;"><img src="{{ asset('img/logo_large.gif') }}" alt="{{ config('app.name') }} Logo" style="width: 350px;margin:0;padding:0;padding-top:10px;"></p>

# One Of Your Clients Has Updated Their Profile Information
\
&nbsp;
Name: {{ $name }}
\
&nbsp;
Email: {{ $email }}
\
&nbsp;
Company Name: {{ $company_name }}
\
&nbsp;
Contact Number: {{ $contact_number }}
\
&nbsp;
Residential Address: {{ $full_address }}
\
&nbsp;
Postal Address: {{ $postal_address }}
\
&nbsp;
Principal Place of Business: {{ $principal_place_of_business }}
\
&nbsp;
\
&nbsp;
Thanks,
\
&nbsp;
{{ config('app.name') }}
@endcomponent