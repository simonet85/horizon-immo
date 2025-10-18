<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} ZB Investments. @lang('All rights reserved.')

**Contact**
Côte d'Ivoire: +225 07 07 69 69 14 | +225 05 45 01 01 99
Afrique du Sud: +27 65 86 87 861
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
