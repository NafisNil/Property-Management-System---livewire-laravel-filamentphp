<x-mail::message>
# Introduction
You have received a new enquiry for your property listing "{{ $enquiry->property->title }}".


The body of your message.
-------------------------------
**Name:** {{ $enquiry['name'] }}  
**Email:** {{ $enquiry['email'] }}  
**Phone:** {{ $enquiry['phone'] ?? 'N/A' }}  
**Message:**  
{{ $enquiry['message'] }}
-------------------------------
<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
