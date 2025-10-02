@php
    // Ensure $logoBase64 is available: if not provided, attempt to load public/favicon.png
    if (!isset($logoBase64) || empty($logoBase64)) {
        $tmpPath = public_path('favicon.png');
        if (file_exists($tmpPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($tmpPath));
        } else {
            $logoBase64 = '';
        }
    }
@endphp

<!-- Reusable PDF header: left logo, centered institution text -->
<table style="width: 100%; color: #000; border-bottom: 1px solid #8e9bb2;">
    <tr>
        <td style="width:20%; vertical-align: middle; padding:8px 12px;">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" style="height:80px; display:block;">
            @endif
        </td>
        <td style="width:60%; text-align: center; vertical-align: middle; padding:8px 12px;">
            <div style="line-height:1.1;">
                <p style="margin:0; font-size:14px; font-weight:700;">UNIVERSITÉ ADVENTISTE ZURCHER</p>
                <p style="margin:2px 0 6px 0; font-weight:700;">BUREAU DES AFFAIRES ACADÉMIQUES</p>
                <p class="text-xs" style="margin:0; font-size:10px; color:#222;">
                    BP 325, Antsirabe 110, MADAGASCAR
                    <br>Tél : 034 18 810 86 / 034 46 000 08 / 034 38 180 81
                    <br>Email : registraroffice@zurcher.edu.mg
                    <br>
                    <span style="font-style: italic; font-family: 'Old English Text MT', 'Gothic', cursive, serif; font-size:10px;">
                        "Préparer aujourd'hui les leaders de demain"
                    </span>
                </p>
            </div>
        </td>
        <td style="width:20%; vertical-align: middle; padding:8px 12px;"></td>
    </tr>
</table>

{{-- Watermark using the same logoBase64 --}}
@if(!empty($logoBase64))
    <div style="position: fixed; top:40%; left:50%; transform: translate(-50%, -50%); width:70%; opacity:0.06; z-index: 0; text-align:center;">
        <img src="{{ $logoBase64 }}" style="width:70%; opacity:0.06; max-width:800px;">
    </div>
@endif

{{-- Page numbering for DomPDF (works when using Barryvdh/DomPDF) --}}
<script type="text/php">
if (isset($pdf)) {
    $font = $fontMetrics->getFont("DejaVuSans", "normal");
    $size = 9;
    $color = array(0,0,0);
    $y = 20; // distance from top
    // right aligned page number
    $x = $pdf->get_width() - 60;
    $pdf->page_text($x, $y, "Page {PAGE_NUM} / {PAGE_COUNT}", $font, $size, $color);
}
</script>
