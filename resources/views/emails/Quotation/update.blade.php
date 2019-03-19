@component('mail::message')
# Quotation Update

{{$data['message']}}

@component('mail::button', ['url' => url($data['url'])])
View Quotation
@endcomponent


Kind Regards,

{{ config('app.name') }} <br>
6th Floor, Cannon Towers II, Moi Avenue <br>
P. O. Box 1922 - 80100, Mombasa, Kenya <br>
Phone: +254 41 2229784/6/2224822 <br>
agency@esl-eastafrica.com <br>
http://www.esl-eastafrica.com <br>
<img src="{{ asset('/images/logo.png') }}" alt="">
<br>
<h5>Powering our Customers to be Leaders in their Markets</h5>

<p style="font-size: small">This email is confidential and intended only for the use of the above named addressee. If you have received this email in error, please delete it immediately and notify us by email or telephone.</p>

@endcomponent
