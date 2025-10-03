<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des étudiants</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size:10px; color:#222 }
        .header { text-align:center; margin-bottom:12px }
        table { width:100%; border-collapse:collapse; margin-top:10px }
        th, td { border:1px solid #ddd; padding:2px 8px; text-align:left }
        th { background:#f3f4f6; font-weight:700 }
    </style>
</head>
<body>
    <?php echo $__env->make('partials.pdf-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="header">
        <h2>Liste des étudiants</h2>
    </div>


    <?php if(isset($grouped) && $grouped): ?>
        <?php $sectionIndex = 0; ?>
        <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mentionName => $studentsList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <h3 style="margin-top:18px; margin-bottom:6px; font-size:14px; font-weight:700; border-top:1px solid #ccc; padding-top:8px;">Mention: <?php echo e($mentionName); ?> (<?php echo e($studentsList->count()); ?>)</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width:10%">Matricule</th>
                        <th style="width:38%">Nom et Prénom</th>
                        <th style="width:15%">Niveau</th>
                        <?php $extraCols = $fields ?? []; ?>
                        <?php if(in_array('email', $extraCols)): ?>
                            <th style="width:20%">Email</th>
                        <?php endif; ?>
                        <?php if(in_array('plain_password', $extraCols)): ?>
                            <th style="width:12%">Mot de passe</th>
                        <?php endif; ?>
                        <?php if(in_array('telephone', $extraCols)): ?>
                            <th style="width:12%">Téléphone</th>
                        <?php endif; ?>
                        <?php if(in_array('religion', $extraCols)): ?>
                            <th style="width:12%">Religion</th>
                        <?php endif; ?>
                        <?php if(in_array('abonne_caf', $extraCols)): ?>
                            <th style="width:8%">Cantine</th>
                        <?php endif; ?>
                        <?php if(in_array('statut_interne', $extraCols)): ?>
                            <th style="width:8%">Résidence</th>
                        <?php endif; ?>
                        <?php if(in_array('taille', $extraCols)): ?>
                            <th style="width:8%">Taille</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sorted = $studentsList->sortBy('matricule')->values();
                    ?>
                    <?php $__currentLoopData = $sorted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($s->matricule ?? ''); ?></td>
                            <td><?php echo e(trim(($s->nom ?? '') . ' ' . ($s->prenom ?? ''))); ?></td>
                            <td>
                                <?php
                                    $lvl = optional($s->yearLevel)->label ?? ($s->year_level_id ?? '');
                                    if (is_string($lvl)) {
                                        $lvl = preg_replace('/\s*\(.*\)$/', '', $lvl);
                                    }
                                ?>
                                <?php echo e($lvl); ?>

                            </td>
                            <?php $ec = $extraCols ?? []; ?>
                            <?php if(in_array('email', $ec)): ?>
                                <td><?php echo e($s->email ?? ''); ?></td>
                            <?php endif; ?>
                            <?php if(in_array('plain_password', $ec)): ?>
                                <td><?php echo e($s->plain_password ?? ''); ?></td>
                            <?php endif; ?>
                            <?php if(in_array('telephone', $ec)): ?>
                                <td><?php echo e($s->telephone ?? ''); ?></td>
                            <?php endif; ?>
                            <?php if(in_array('religion', $ec)): ?>
                                <td><?php echo e($s->religion ?? ''); ?></td>
                            <?php endif; ?>
                            <?php if(in_array('abonne_caf', $ec)): ?>
                                <td><?php echo e(($s->abonne_caf) ? 'Oui' : 'Non'); ?></td>
                            <?php endif; ?>
                            <?php if(in_array('statut_interne', $ec)): ?>
                                <td><?php echo e($s->statut_interne ?? ''); ?></td>
                            <?php endif; ?>
                            <?php if(in_array('taille', $ec)): ?>
                                <td><?php echo e($s->taille ?? ''); ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <?php $extraCols = $fields ?? []; ?>
        <table>
            <thead>
                <tr>
                    <th style="width:16%">Matricule</th>
                    <th style="width:38%">Nom et Prénom</th>
                    <th style="width:15%">Niveau</th>
                    <?php if(in_array('email', $extraCols)): ?>
                        <th style="width:20%">Email</th>
                    <?php endif; ?>
                    <?php if(in_array('plain_password', $extraCols)): ?>
                        <th style="width:12%">Mot de passe</th>
                    <?php endif; ?>
                    <?php if(in_array('telephone', $extraCols)): ?>
                        <th style="width:12%">Téléphone</th>
                    <?php endif; ?>
                    <?php if(in_array('religion', $extraCols)): ?>
                        <th style="width:12%">Religion</th>
                    <?php endif; ?>
                    <?php if(in_array('abonne_caf', $extraCols)): ?>
                        <th style="width:8%">Abonné CAF</th>
                    <?php endif; ?>
                    <?php if(in_array('statut_interne', $extraCols)): ?>
                        <th style="width:8%">Résidence</th>
                    <?php endif; ?>
                    <?php if(in_array('taille', $extraCols)): ?>
                        <th style="width:6%">Taille</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $students->sortBy('matricule')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($s->matricule ?? ''); ?></td>
                        <td><?php echo e(trim(($s->nom ?? '') . ' ' . ($s->prenom ?? ''))); ?></td>
                        <td>
                            <?php
                                $lvl = optional($s->yearLevel)->label ?? ($s->year_level_id ?? '');
                                if (is_string($lvl)) {
                                    $lvl = preg_replace('/\s*\(.*\)$/', '', $lvl);
                                }
                            ?>
                            <?php echo e($lvl); ?>

                        </td>
                        <?php $ec = $extraCols ?? []; ?>
                        <?php if(in_array('email', $ec)): ?>
                            <td><?php echo e($s->email ?? ''); ?></td>
                        <?php endif; ?>
                        <?php if(in_array('plain_password', $ec)): ?>
                            <td><?php echo e($s->plain_password ?? ''); ?></td>
                        <?php endif; ?>
                        <?php if(in_array('telephone', $ec)): ?>
                            <td><?php echo e($s->telephone ?? ''); ?></td>
                        <?php endif; ?>
                        <?php if(in_array('religion', $ec)): ?>
                            <td><?php echo e($s->religion ?? ''); ?></td>
                        <?php endif; ?>
                        <?php if(in_array('abonne_caf', $ec)): ?>
                            <td><?php echo e(($s->abonne_caf) ? 'Oui' : 'Non'); ?></td>
                        <?php endif; ?>
                        <?php if(in_array('statut_interne', $ec)): ?>
                            <td><?php echo e($s->statut_interne ?? ''); ?></td>
                        <?php endif; ?>
                        <?php if(in_array('taille', $ec)): ?>
                            <td><?php echo e($s->taille ?? ''); ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php
        // Calculer le total d'étudiants affichés
        if(isset($grouped) && $grouped) {
            $total = 0;
            foreach($grouped as $studentsList) {
                $total += $studentsList->count();
            }
        } else {
            // $students peut être une Collection ou un tableau
            if(isset($students) && is_object($students) && method_exists($students, 'count')) {
                $total = $students->count();
            } elseif(isset($students) && is_array($students)) {
                $total = count($students);
            } else {
                $total = 0;
            }
        }

        // Nom de l'utilisateur qui a exporté (utilise Auth si disponible)
        $exporter = optional(auth()->user())->name ?? (optional(auth()->user())->username ?? 'Utilisateur inconnu');
    ?>

    <div style="margin-top:12px; text-align:left; font-size:12px;">
        <strong>Arrêté au nombre total :</strong> <?php echo e($total); ?> étudiant<?php echo e($total > 1 ? 's' : ''); ?>

    </div>

    <footer style="position: fixed; bottom: 0; left: 0; right: 0; font-size:11px; color:#555; border-top:1px solid #ccc; padding:6px 8px; text-align:right; background: white;">
        Exporté par : <?php echo e($exporter); ?> — le <?php echo e(now()->format('d/m/Y H:i')); ?>

    </footer>
</body>
</html><?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/superadmin/students/students-pdf.blade.php ENDPATH**/ ?>