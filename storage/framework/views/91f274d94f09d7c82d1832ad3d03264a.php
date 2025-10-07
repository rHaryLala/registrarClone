<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des étudiants - <?php echo e($course->sigle ?? 'Cours'); ?></title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 10px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
        .header { margin-bottom: 12px; }
        .title { font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <?php
        // Try to embed a logo from public path for DomPDF compatibility
        $logoPath = public_path('favicon.png');
        $logoData = null;
        if (file_exists($logoPath)) {
            $type = pathinfo($logoPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoPath);
            $logoData = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
    ?>

    <div class="header" style="margin-bottom:14px;">
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="width:85px; vertical-align:middle;">
                    <?php if($logoData): ?>
                        <img src="<?php echo e($logoData); ?>" alt="logo" style="width:72px; height:auto;" />
                    <?php endif; ?>
                </td>
                <td style="text-align:left; vertical-align:middle;">
                    <div style="font-size:16px; font-weight:bold;"><?php echo e($course->sigle ?? ''); ?></div>
                    <div style="font-size:14px; font-weight:600; margin-top:4px;"><?php echo e($course->nom ?? ''); ?></div>
                    <div style="font-size:12px; margin-top:6px;">Professeur: <?php echo e($course->teacher->name ?? 'Non attribué'); ?></div>
                </td>
                <td style="width:140px; text-align:right; vertical-align:middle; font-size:10px;">
                    <div>Date d'export: <br> <?php echo e(now()->isoFormat('LL LTS')); ?></div>
                </td>
            </tr>
        </table>
        <hr style="border:none; border-top:1px solid #444; margin-top:10px;" />
    </div>

    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Mention</th>
                <th>Niveau</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $course->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($student->matricule); ?></td>
                    <td><?php echo e($student->nom); ?></td>
                    <td><?php echo e($student->prenom); ?></td>
                    <td><?php echo e($student->email); ?></td>
                    <td><?php echo e(optional($student->mention)->nom); ?></td>
                    <td><?php echo e($student->yearLevel ? $student->yearLevel->label : ($student->annee_etude ?? $student->niveau_etude ?? '')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH D:\PROJET REGISTRAIRE\registrarClone\registrar\resources\views/dean/courses/students-pdf.blade.php ENDPATH**/ ?>