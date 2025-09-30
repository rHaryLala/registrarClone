<style>
    /* Reduce default page margins for PDF rendering (top/bottom smaller) */
    @page { margin: 8mm 10mm; }
    /* Ensure body doesn't add extra margins when rendering to PDF */
    body { margin: 0; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 9px; }
    .head { border-bottom: 1px solid #6b6969; margin-bottom: 5px; }
    .infotitre { background-color: #7d7a8c; color: white; border-top-left-radius: 8px; border-top-right-radius: 8px; padding-left: 15px; height: 20px; padding-top: 5px; }
    .informationbox { border: 1px solid #6b6969; margin: 0px; }
    .tbl { width: 100%; border-collapse: collapse; }
    .tbl td, .tbl th { border: 1px solid #c8cae4; padding: 2px 6px; height: 8px; } /* Hauteur réduite ici */
    .tbl th { background: #dfe0ef; }
    /* Smaller table style for compact sections (payment breakdown) */
    .payment-table td, .payment-table th {
        padding: 1px 4px;
        font-size: 7px;
        height: 8px;
    }
    .payment-table input {
        font-size: 8px;
        padding: 1px;
    }
    /* Date input that fills the parent column and shows a border bounded by the left column */
    .date-input {
        display: block;
        width: 100%;
        padding: 2px 4px;
        font-size: 8px;
        background: transparent;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .marck { background-color: #e8e6e6; font-weight: bold; }
    .center { text-align: center; }
    .inline { display: inline-grid; width: 100%; }
    .flex { display: flex; padding-left: 10px; padding-right: 10px; padding-top: 5px; padding-bottom: 5px; width: 90%; }
    .footer { border-top: 1px solid black; height: 200px; }
    .signature-table td { border: none !important; }
    /* Interligne plus petit */
    table, tr, td, th, p, div, span, b, h2, h3, h4 {
        line-height: 1 !important;
    }
    th {
        text-align: left;
    }
</style>
<?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/layouts/pdf-style.blade.php ENDPATH**/ ?>