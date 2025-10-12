@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel' || trim($slot) === 'ZB Investments')
<img src="{{ $url }}/images/logo-zb.png" class="logo" alt="ZB Investments Logo" style="max-height: 60px; width: auto;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
