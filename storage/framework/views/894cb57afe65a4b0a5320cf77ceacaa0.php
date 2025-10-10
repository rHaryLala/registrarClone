<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fiche de présence semaine - <?php echo e(optional($mention)->nom ?? 'Liste étudiants'); ?></title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size:10px; color:#222; margin:0 }
        .header { text-align:center; margin-bottom:6px }
        .meta { width:100%; margin-bottom:8px }
        .meta td { padding:3px 6px; vertical-align:top }
        .table { width:100%; border-collapse:collapse; font-size:10px }
        .table th, .table td { border:1px solid #444; padding:4px; text-align:left; height:24px; line-height:24px; vertical-align:middle }
        .table th { background:#f3f4f6 }
        .center { text-align:center }
        .small { font-size:10px }
        .notes { margin-top:8px; font-size:10px }
        .mention-title { margin-top:12px; margin-bottom:6px; font-weight:700 }
        .nowrap { white-space:nowrap }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0">Université Adventiste Zurcher</h2>
        <h3 style="margin:2px 0">Fiche de présence — Semaine de prière (Lundi→Jeudi)</h3>
    </div>

    <table class="meta">
        <tr>
            <td><strong>Mention :</strong> <?php echo e(optional($mention)->nom ?? (isset($students) ? 'Toutes mentions' : '-')); ?></td>
            <td><strong>Année académique :</strong> <?php echo e(optional($academicYear)->libelle ?? '-'); ?></td>
            <td><strong>Semestre :</strong> <?php echo e(optional($semester)->libelle ?? '-'); ?></td>
        </tr>
    </table>

    <?php
        // days header: Lundi -> Jeudi
        $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi'];

        // group students by mention
        $groups = [];
        if (!empty($students)) {
            try {
                $groups = $students->groupBy(function($s){ return optional($s->mention)->nom ?? 'Sans mention'; })->toArray();
            } catch (Exception $e) {
                $tmp = [];
                foreach($students as $s) {
                    $k = isset($s->mention) ? ($s->mention->nom ?? 'Sans mention') : (is_array($s) && isset($s['mention_nom']) ? $s['mention_nom'] : 'Sans mention');
                    $tmp[$k][] = $s;
                }
                $groups = $tmp;
            }
        }
    ?>

    <?php if(empty($groups)): ?>
        <div class="small">Aucun étudiant trouvé pour les critères sélectionnés.</div>
    <?php else: ?>
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentionName => $studentsForMention): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mention-title">Mention : <?php echo e($mentionName); ?> — Total étudiants : <?php echo e(count($studentsForMention)); ?></div>

            <table class="table">
                <thead>
                    <tr>
                        <th style="width:12%">Matricule</th>
                        <th style="width:50%">Nom et prénom</th>
                        <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th class="center" style="width:9%"><?php echo e($d); ?></th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $studentsForMention; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="nowrap"><?php echo e(is_object($st) ? ($st->matricule ?? '-') : ($st['matricule'] ?? '-')); ?></td>
                            <td><?php echo e(is_object($st) ? trim((($st->nom ?? '') . ' ' . ($st->prenom ?? ''))) : trim((($st['nom'] ?? '') . ' ' . ($st['prenom'] ?? '')))); ?></td>
                            <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td></td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div style="page-break-after:always"></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <div class="notes">
        <strong>Remarques :</strong>
        <ul>
            <li>Conserver une copie papier au dossier de l'enseignant.</li>
            <li>Cette fiche ne remplace pas le registre officiel de l'établissement.</li>
        </ul>
    </div>
</body>
</html><?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/PDFexport/attendance-week.blade.php ENDPATH**/ ?>