<x-mail::message>
# Post Created Successfully

<b>Title :&nbsp;</b> {{$mailData['postTitle']}}<br>
<b>Author Name :&nbsp;</b> {{$mailData['name']}}<br>
<b>Post Content :&nbsp;</b>{{$mailData['content']}}<br>

Thanks,<br>
{{ config('app.name') ?? 'Blog Web Wirh Role & Permission' }}
</x-mail::message>
