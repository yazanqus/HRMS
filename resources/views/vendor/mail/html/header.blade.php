<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<!-- <img src="{{url('/hr360-3-noBG.png')}}" style=" width:150px;height:50px;" class="logo" alt="Logo">
{{asset('storage/hr360-3-noBG.png')}}
{{url('/hr360-3-noBG.png')}} -->
@else
<img src="{{url('/hr360-3-noBG.png')}}" style=" width:150px;height:50px;" class="logo" alt="Logo">
{{ $slot }}
@endif
</a>
</td>
</tr>
