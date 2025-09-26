<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aperçu export - {{ $ptype }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body { background-color:#63748b; height:100vh; margin:0; }
        .topbar { background:#0f1724; color: #fff; display:flex; align-items:center; padding:6px 10px; }
        .topbar a.logo { color: #fff; text-decoration: none; display:flex; align-items:center; }
        .topbar img { width:24px; height:24px; margin-right:8px; }
        .topbar .title { flex:1; text-align:center; font-weight:700; }
        .topbar .actions { text-align:right; }
        .frame-wrap { overflow:auto; width:100%; height:calc(100vh - 42px); padding:12px; }
        .frame { border:1px solid #475460; box-shadow:0 0 20px #475469; padding:35px; background:#fff; width:800px; margin:20px auto; }
        .controls { display:flex; gap:8px; justify-content:center; margin-bottom:12px; }
        .btn-hidden { opacity:0; pointer-events:none; }
    </style>
</head>
<body>

    <div class="topbar">
        <div style="width:33%;">
            <a href="/" class="logo">
                <img src="{{ asset('favicon.png') }}" alt="logo">
                <strong style="color:#fff; margin-left:4px;">Registrar</strong>
            </a>
        </div>
        <div class="title">
            <p class="b-title center"><strong>{{ $ptype }}</strong></p>
        </div>
        <div class="actions" style="width:33%;">
            <form id="exportForm" method="post" action="#">
                @csrf
                <input type="hidden" name="htmlContent" id="htmlContent" value="">
                <button type="submit" id="btnToExcel" class="btn btn-sm btn-success btn-hidden">Excel</button>
                <button type="button" id="btnExportImage" class="btn btn-sm btn-primary">Exporter PDF (image)</button>
            </form>
        </div>
    </div>

    <div class="frame-wrap">
        <div class="frame">
            <iframe id="previewFrame" style="width:100%; min-height:1020px; border: none;" sandbox="allow-scripts" srcdoc="Chargement..."></iframe>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        const ptype = '{{ $ptype }}';
        const scale = parseFloat('{{ $scale }}');
        const quality = parseFloat('{{ $quality }}');

        async function loadContent() {
            const iframe = document.getElementById('previewFrame');
                // Check if a student_id was provided to the wrapper URL and forward it
                const params = new URLSearchParams(window.location.search);
                const studentId = params.get('student_id');
                let url = '/preview/content?ptype=' + encodeURIComponent(ptype) + '&full=1';
                if (studentId) {
                    url += '&student_id=' + encodeURIComponent(studentId);
                }
                // Fetch the full HTML using fetch with credentials so cookies/session are sent, then inject as srcdoc
                try {
                    const res = await fetch(url, { credentials: 'include' });
                    if (res.ok) {
                        const html = await res.text();
                        // If the server returned the login page (session expired), detect and show a helpful message
                        const lowered = html.toLowerCase();
                        if (lowered.includes('login') && (lowered.includes('mot de passe') || lowered.includes('connexion') || lowered.includes('login'))) {
                            iframe.srcdoc = '<div style="padding:20px">Session expirée ou accès non autorisé. Veuillez vous reconnecter dans cet onglet, puis rechargez cette prévisualisation.</div>';
                        } else {
                            // set returned full HTML as srcdoc; resources should be absolute URLs (previewContent rewrites them)
                            iframe.srcdoc = html;
                        }
                    } else {
                        iframe.srcdoc = '<div style="padding:20px">Erreur lors du chargement de la prévisualisation (' + res.status + ').</div>';
                    }
                } catch (e) {
                    iframe.srcdoc = '<div style="padding:20px">Erreur lors du chargement de la prévisualisation.</div>';
                }
        }

        // For exact server-generated PDF parity, open the server PDF endpoint instead of client-side export.
        document.getElementById('btnExportImage').addEventListener('click', function(){
            const params = new URLSearchParams(window.location.search);
            const studentId = params.get('student_id');
            if (studentId) {
                // open server PDF which uses DomPDF and the same Blade view
                const url = '/recap/' + encodeURIComponent(studentId) + '/pdf';
                window.open(url, '_blank');
            } else {
                alert('Aucun étudiant sélectionné pour générer le PDF serveur.');
            }
        });

        // Add content HTML to hidden field for Excel export if needed
        document.getElementById('exportForm').addEventListener('submit', function(e){
            // prevent default for now (no server handler)
            e.preventDefault();
            const html = document.getElementById('printThisContent').outerHTML;
            document.getElementById('htmlContent').value = html;
            alert('HTML ready for Excel export (not implemented in this preview).');
        });

        // Load once on open
        window.addEventListener('DOMContentLoaded', loadContent);
    </script>
</body>
</html>
