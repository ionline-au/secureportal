@component('mail::message')

<p style="text-align: center;"><img src="{{ asset('img/logo_large.gif') }}" alt="{{ config('app.name') }} Logo" style="width: 350px;margin:0;padding:0;padding-top:10px;"></p>

# A File From A Counting House Has Been Uploaded For You
\
A team member from A Counting House has uploaded some file(s) for you to review. Please note that if you are reviewing PDF files, the latest version of Adobe Reader may be required. If you are having trouble viewing the files, please download the latest Adobe Reader <a href="https://get.adobe.com/reader/">here</a>.

@component('mail::button', ['url' => 'https://secureportal.acountinghouse.com/'])
    Click here to login and view the files
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent