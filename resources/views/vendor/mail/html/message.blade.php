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
© {{ date('Y') }} ZB Investments. Tous droits réservés.<br>
Votre partenaire immobilier en Afrique du Sud<br>
📧 <a href="mailto:info@zbinvestments-ci.com">info@zbinvestments-ci.com</a> | 📞 +27 65 86 87 861
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
