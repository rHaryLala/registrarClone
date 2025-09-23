<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Mention;
use App\Models\Semester;
use App\Models\Parcours;
use App\Models\StudentFinance;
use App\Models\YearLevel;
use App\Models\Finance;
use Illuminate\Support\Facades\DB;
use App\Traits\TracksLastChange;

class Student extends Model
{
    use HasFactory, TracksLastChange;

    protected $fillable = [
        'nom', 'prenom', 'sexe', 'date_naissance', 'lieu_naissance', 
        'nationalite', 'religion', 'etat_civil', 'passport_status', 
        'passport_numero', 'passport_pays_emission', 'passport_date_emission', 
        'passport_date_expiration', 'nom_conjoint', 'nb_enfant', 'cin_numero', 
        'cin_date_delivrance', 'cin_lieu_delivrance', 'nom_pere', 'profession_pere', 
        'contact_pere', 'nom_mere', 'profession_mere', 'contact_mere', 
        'adresse_parents', 'telephone', 'email', 'adresse', 'region', 
        'district', 'bacc_serie', 'bacc_date_obtention', 'bursary_status', 
        'sponsor_nom', 'sponsor_prenom', 'sponsor_telephone', 'sponsor_adresse',
            'year_level_id', 'mention_id', 'parcours_id', 'semester_id', 'matricule', 'account_code', 'image',
            'taille',
        'abonne_caf', 'statut_interne', 'password', 'plain_password', 'academic_year_id'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'passport_date_emission' => 'date',
        'passport_date_expiration' => 'date',
        'cin_date_delivrance' => 'date',
        'bacc_date_obtention' => 'integer',
        'passport_status' => 'boolean',
        'bursary_status' => 'boolean',
        'abonne_caf' => 'boolean',
        'statut_interne' => 'string',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')
            ->withTimestamps()
            ->withPivot('deleted_at');
    }

    public function mention()
    {
        return $this->belongsTo(Mention::class);
    }
    
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function parcours()
    {
        return $this->belongsTo(Parcours::class, 'parcours_id');
    }

    public function year()
    {
        return $this->belongsTo(\App\Models\Year::class);
    }

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class, 'year_level_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function finances()
    {
        return $this->hasMany(Finance::class, 'student_id', 'matricule');
    }

    public function generateAccountCode()
    {
        $nom = strtoupper(preg_replace('/\s+/', '', $this->nom));
        $prenom = strtoupper(preg_replace('/\s+/', '', $this->prenom));
        
        // Début du code (S)
        $code = 'S';
        
        // Gestion du nom (3 lettres)
        if (strlen($nom) >= 3) {
            $code .= substr($nom, 0, 3);
        } else {
            // Si nom < 3 lettres, prendre tout le nom
            $code .= $nom;
            // Et compléter avec le début du prénom si disponible
            if ($prenom) {
                $code .= substr($prenom, 0, 3 - strlen($nom));
            } else {
                // Si pas de prénom, compléter avec X
                $code .= str_repeat('X', 3 - strlen($nom));
            }
        }

        // Gestion du prénom (2 lettres)
        if ($prenom) {
            $code .= substr($prenom, 0, 2);
        } else {
            // Si pas de prénom, prendre les 4e et 5e lettres du nom si disponibles
            if (strlen($nom) > 3) {
                $code .= substr($nom, 3, 2);
            } else {
                $code .= 'XX';
            }
        }

        // Cherche le dernier code existant avec ce préfixe
        $prefix = substr($code, 0, 6);
        
        // Vérifier à la fois dans students et account_codes
        $lastStudent = self::where('account_code', 'like', $prefix . '%')
            ->orderByDesc('account_code')
            ->first();
            
        $lastAccount = DB::table('account_codes')
            ->where('account_code', 'like', $prefix . '%')
            ->orderByDesc('account_code')
            ->first();
            
        // Déterminer le dernier numéro utilisé
        $lastStudentDigits = $lastStudent ? intval(substr($lastStudent->account_code, strlen($prefix), 2)) : 0;
        $lastAccountDigits = $lastAccount ? intval(substr($lastAccount->account_code, strlen($prefix), 2)) : 0;
        
        // Prendre le plus grand des deux
        $lastDigits = max($lastStudentDigits, $lastAccountDigits);
        $nextDigits = $lastDigits + 1;
        
        // Générer le nouveau code
        $code = $prefix . str_pad($nextDigits, 2, '0', STR_PAD_LEFT);
        
        // Vérifier si le code existe déjà et incrémenter si nécessaire
        while (self::where('account_code', $code)->exists() || 
               DB::table('account_codes')->where('account_code', $code)->exists()) {
            $nextDigits++;
            $code = $prefix . str_pad($nextDigits, 2, '0', STR_PAD_LEFT);
        }

        // Sauvegarder dans la table students
        $this->account_code = $code;
        $this->save();

        // Sauvegarder dans la table account_codes
        DB::table('account_codes')->insert([
            'account_code' => $code,
            'matricule' => $this->matricule,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $code;
    }

    public function generateMatricule($mentionId)
    {
        $mention = Mention::findOrFail($mentionId);
        $prefixes = [
            'Théologie' => '1',
            'Gestion' => '2',
            'Informatique' => '3',
            'Sciences Infirmières' => '4',
            'Education' => '5',
            'Communication' => '6',
            'Études Anglophones' => '7',
            'Droit' => '9',
        ];
        
        $prefix = $prefixes[$mention->nom] ?? '0';
        
        $lastStudent = self::where('matricule', 'like', $prefix . '%')
            ->where('matricule', 'REGEXP', '^' . $prefix . '[0-9]{4}$')
            ->orderByDesc('matricule')
            ->first();
        
        if ($lastStudent) {
            $lastNumber = (int)substr($lastStudent->matricule, 1);
            $nextNumber = $lastNumber + 1;
            
            if ($nextNumber > 9999) {
                throw new \Exception("Numéro de matricule dépassé pour la mention " . $mention->nom);
            }
        } else {
            $nextNumber = 1;
        }
        
        $matricule = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        
        while (self::where('matricule', $matricule)->exists()) {
            $nextNumber++;
            if ($nextNumber > 9999) {
                throw new \Exception("Numéro de matricule dépassé pour la mention " . $mention->nom);
            }
            $matricule = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }
        
        $this->matricule = $matricule;
        $this->save();

        // Sauvegarder dans la table account_codes si account_code existe déjà
        if ($this->account_code) {
            DB::table('account_codes')->insert([
                'account_code' => $this->account_code, 
                'matricule' => $matricule,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return $matricule;
    }

    public function generatePassword()
    {
        // Générer 6 chiffres aléatoires
        $randomDigits = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Obtenir l'année actuelle
        $currentYear = date('Y');
        
        // Construire le mot de passe au format: 123456.Student.2024
        $plainPassword = $randomDigits . 'Student' . $currentYear;
        
        // Hasher le mot de passe pour le stockage sécurisé
        $this->password = bcrypt($plainPassword);
        // Stocker aussi la version en clair pour référence administrative
        $this->plain_password = $plainPassword;
        
        $this->save();
        
        return $plainPassword;
    }

    /**
     * The user who last changed this model.
     */
    public function lastChangedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'last_change_user_id');
    }
}