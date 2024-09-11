<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<a href="{{ url('/') }}" style="text-decoration: none">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQcjo30y8eRF33cjOROo9ihpsdDDlFstv9YeA&s" style="width: 165px" alt="">
</a>
@endif
</a>
</td>
</tr>
