<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer le premier utilisateur ou créer un utilisateur par défaut
        $user = User::first();
        
        if (!$user) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez créer un utilisateur d\'abord.');
            return;
        }

        $this->command->info('Création des catégories pour l\'utilisateur: ' . $user->name);

        // Catégories de DÉPENSES
        $expenseCategories = [
            // Alimentation & Restauration
            [
                'name' => 'Alimentation',
                'type' => 'expense',
                'color' => '#FF6B6B',
                'icon' => 'fas fa-shopping-cart',
                'description' => 'Courses alimentaires et produits de base'
            ],
            [
                'name' => 'Restaurants',
                'type' => 'expense',
                'color' => '#FF8E8E',
                'icon' => 'fas fa-utensils',
                'description' => 'Repas au restaurant'
            ],
            [
                'name' => 'Fast-food',
                'type' => 'expense',
                'color' => '#FFB3B3',
                'icon' => 'fas fa-hamburger',
                'description' => 'Restauration rapide'
            ],
            [
                'name' => 'Livraison de repas',
                'type' => 'expense',
                'color' => '#FFD1D1',
                'icon' => 'fas fa-motorcycle',
                'description' => 'Livraison à domicile'
            ],
            [
                'name' => 'Cafés & Boissons',
                'type' => 'expense',
                'color' => '#8B4513',
                'icon' => 'fas fa-coffee',
                'description' => 'Cafés, thés et boissons'
            ],

            // Logement
            [
                'name' => 'Loyer',
                'type' => 'expense',
                'color' => '#4ECDC4',
                'icon' => 'fas fa-home',
                'description' => 'Loyer mensuel'
            ],
            [
                'name' => 'Charges',
                'type' => 'expense',
                'color' => '#45B7D1',
                'icon' => 'fas fa-bolt',
                'description' => 'Électricité, gaz, eau'
            ],
            [
                'name' => 'Assurance habitation',
                'type' => 'expense',
                'color' => '#96CEB4',
                'icon' => 'fas fa-shield-alt',
                'description' => 'Assurance logement'
            ],
            [
                'name' => 'Entretien & Réparations',
                'type' => 'expense',
                'color' => '#A8E6CF',
                'icon' => 'fas fa-tools',
                'description' => 'Réparations et maintenance'
            ],
            [
                'name' => 'Mobilier & Décoration',
                'type' => 'expense',
                'color' => '#FFEAA7',
                'icon' => 'fas fa-couch',
                'description' => 'Ameublement et décoration'
            ],

            // Transport
            [
                'name' => 'Essence/Carburant',
                'type' => 'expense',
                'color' => '#FFD93D',
                'icon' => 'fas fa-gas-pump',
                'description' => 'Carburant pour véhicule'
            ],
            [
                'name' => 'Transport en commun',
                'type' => 'expense',
                'color' => '#6C5CE7',
                'icon' => 'fas fa-bus',
                'description' => 'Bus, métro, train'
            ],
            [
                'name' => 'Taxis & VTC',
                'type' => 'expense',
                'color' => '#A29BFE',
                'icon' => 'fas fa-taxi',
                'description' => 'Taxis et VTC'
            ],
            [
                'name' => 'Entretien véhicule',
                'type' => 'expense',
                'color' => '#FD79A8',
                'icon' => 'fas fa-wrench',
                'description' => 'Réparations et maintenance véhicule'
            ],
            [
                'name' => 'Assurance auto',
                'type' => 'expense',
                'color' => '#FDCB6E',
                'icon' => 'fas fa-car',
                'description' => 'Assurance automobile'
            ],
            [
                'name' => 'Parking & Péages',
                'type' => 'expense',
                'color' => '#E17055',
                'icon' => 'fas fa-parking',
                'description' => 'Parking et péages autoroute'
            ],

            // Santé & Bien-être
            [
                'name' => 'Médecin & Spécialistes',
                'type' => 'expense',
                'color' => '#74B9FF',
                'icon' => 'fas fa-user-md',
                'description' => 'Consultations médicales'
            ],
            [
                'name' => 'Pharmacie',
                'type' => 'expense',
                'color' => '#55A3FF',
                'icon' => 'fas fa-pills',
                'description' => 'Médicaments et produits pharmaceutiques'
            ],
            [
                'name' => 'Optique & Lunettes',
                'type' => 'expense',
                'color' => '#0984E3',
                'icon' => 'fas fa-glasses',
                'description' => 'Lunettes et soins optiques'
            ],
            [
                'name' => 'Dentiste',
                'type' => 'expense',
                'color' => '#00B894',
                'icon' => 'fas fa-tooth',
                'description' => 'Soins dentaires'
            ],
            [
                'name' => 'Sport & Fitness',
                'type' => 'expense',
                'color' => '#00CEC9',
                'icon' => 'fas fa-dumbbell',
                'description' => 'Abonnements sport et fitness'
            ],
            [
                'name' => 'Soins personnels',
                'type' => 'expense',
                'color' => '#FAB1A0',
                'icon' => 'fas fa-spa',
                'description' => 'Soins beauté et bien-être'
            ],

            // Loisirs & Culture
            [
                'name' => 'Cinéma & Spectacles',
                'type' => 'expense',
                'color' => '#E84393',
                'icon' => 'fas fa-film',
                'description' => 'Cinéma, théâtre, concerts'
            ],
            [
                'name' => 'Musées & Expositions',
                'type' => 'expense',
                'color' => '#6C5CE7',
                'icon' => 'fas fa-landmark',
                'description' => 'Musées et expositions'
            ],
            [
                'name' => 'Livres & Presse',
                'type' => 'expense',
                'color' => '#A29BFE',
                'icon' => 'fas fa-book',
                'description' => 'Livres, magazines, presse'
            ],
            [
                'name' => 'Jeux vidéo',
                'type' => 'expense',
                'color' => '#FD79A8',
                'icon' => 'fas fa-gamepad',
                'description' => 'Jeux vidéo et gaming'
            ],
            [
                'name' => 'Sorties & Activités',
                'type' => 'expense',
                'color' => '#FDCB6E',
                'icon' => 'fas fa-glass-cheers',
                'description' => 'Sorties entre amis et activités'
            ],
            [
                'name' => 'Voyages & Vacances',
                'type' => 'expense',
                'color' => '#E17055',
                'icon' => 'fas fa-plane',
                'description' => 'Voyages et vacances'
            ],

            // Communication & Technologie
            [
                'name' => 'Téléphone mobile',
                'type' => 'expense',
                'color' => '#74B9FF',
                'icon' => 'fas fa-mobile-alt',
                'description' => 'Forfait mobile et téléphone'
            ],
            [
                'name' => 'Internet & Box',
                'type' => 'expense',
                'color' => '#55A3FF',
                'icon' => 'fas fa-wifi',
                'description' => 'Internet et box internet'
            ],
            [
                'name' => 'Ordinateur & Électronique',
                'type' => 'expense',
                'color' => '#0984E3',
                'icon' => 'fas fa-laptop',
                'description' => 'Ordinateurs et électronique'
            ],
            [
                'name' => 'Logiciels & Applications',
                'type' => 'expense',
                'color' => '#00B894',
                'icon' => 'fas fa-download',
                'description' => 'Logiciels et applications payantes'
            ],
            [
                'name' => 'Streaming & Divertissement',
                'type' => 'expense',
                'color' => '#00CEC9',
                'icon' => 'fas fa-play-circle',
                'description' => 'Services de streaming'
            ],

            // Vêtements & Mode
            [
                'name' => 'Vêtements',
                'type' => 'expense',
                'color' => '#FAB1A0',
                'icon' => 'fas fa-tshirt',
                'description' => 'Vêtements et habillement'
            ],
            [
                'name' => 'Chaussures',
                'type' => 'expense',
                'color' => '#E84393',
                'icon' => 'fas fa-shoe-prints',
                'description' => 'Chaussures et accessoires'
            ],
            [
                'name' => 'Accessoires',
                'type' => 'expense',
                'color' => '#6C5CE7',
                'icon' => 'fas fa-gem',
                'description' => 'Accessoires et bijoux'
            ],
            [
                'name' => 'Coiffeur & Beauté',
                'type' => 'expense',
                'color' => '#A29BFE',
                'icon' => 'fas fa-cut',
                'description' => 'Coiffeur et soins beauté'
            ],

            // Services & Administratif
            [
                'name' => 'Assurance (vie, santé)',
                'type' => 'expense',
                'color' => '#FD79A8',
                'icon' => 'fas fa-shield-alt',
                'description' => 'Assurances personnelles'
            ],
            [
                'name' => 'Banque & Frais',
                'type' => 'expense',
                'color' => '#FDCB6E',
                'icon' => 'fas fa-university',
                'description' => 'Frais bancaires'
            ],
            [
                'name' => 'Impôts & Taxes',
                'type' => 'expense',
                'color' => '#E17055',
                'icon' => 'fas fa-file-invoice-dollar',
                'description' => 'Impôts et taxes'
            ],
            [
                'name' => 'Services publics',
                'type' => 'expense',
                'color' => '#74B9FF',
                'icon' => 'fas fa-building',
                'description' => 'Services publics divers'
            ],
            [
                'name' => 'Garde d\'enfants',
                'type' => 'expense',
                'color' => '#55A3FF',
                'icon' => 'fas fa-baby',
                'description' => 'Garde d\'enfants et crèche'
            ],

            // Éducation & Formation
            [
                'name' => 'Formation continue',
                'type' => 'expense',
                'color' => '#0984E3',
                'icon' => 'fas fa-graduation-cap',
                'description' => 'Formation et développement professionnel'
            ],
            [
                'name' => 'Cours & Ateliers',
                'type' => 'expense',
                'color' => '#00B894',
                'icon' => 'fas fa-chalkboard-teacher',
                'description' => 'Cours et ateliers divers'
            ],
            [
                'name' => 'Fournitures scolaires',
                'type' => 'expense',
                'color' => '#00CEC9',
                'icon' => 'fas fa-pencil-alt',
                'description' => 'Fournitures scolaires et bureau'
            ],
            [
                'name' => 'Frais de scolarité',
                'type' => 'expense',
                'color' => '#FAB1A0',
                'icon' => 'fas fa-school',
                'description' => 'Frais de scolarité et éducation'
            ],
        ];

        // Catégories de REVENUS
        $incomeCategories = [
            [
                'name' => 'Salaire principal',
                'type' => 'income',
                'color' => '#77DD77',
                'icon' => 'fas fa-briefcase',
                'description' => 'Salaire principal du travail'
            ],
            [
                'name' => 'Bonus & Primes',
                'type' => 'income',
                'color' => '#89CFF0',
                'icon' => 'fas fa-gift',
                'description' => 'Bonus et primes professionnelles'
            ],
            [
                'name' => 'Heures supplémentaires',
                'type' => 'income',
                'color' => '#FDFD96',
                'icon' => 'fas fa-clock',
                'description' => 'Heures supplémentaires payées'
            ],
            [
                'name' => 'Freelance & Missions',
                'type' => 'income',
                'color' => '#FFB347',
                'icon' => 'fas fa-laptop-code',
                'description' => 'Travail freelance et missions'
            ],
            [
                'name' => 'Intérêts bancaires',
                'type' => 'income',
                'color' => '#FF6961',
                'icon' => 'fas fa-percentage',
                'description' => 'Intérêts sur comptes épargne'
            ],
            [
                'name' => 'Dividendes',
                'type' => 'income',
                'color' => '#CB99C9',
                'icon' => 'fas fa-chart-line',
                'description' => 'Dividendes d\'investissements'
            ],
            [
                'name' => 'Revenus locatifs',
                'type' => 'income',
                'color' => '#FDFD96',
                'icon' => 'fas fa-home',
                'description' => 'Revenus de location immobilière'
            ],
            [
                'name' => 'Royalties',
                'type' => 'income',
                'color' => '#FFB347',
                'icon' => 'fas fa-copyright',
                'description' => 'Royalties et droits d\'auteur'
            ],
            [
                'name' => 'Remboursements',
                'type' => 'income',
                'color' => '#FF6961',
                'icon' => 'fas fa-undo',
                'description' => 'Remboursements divers'
            ],
            [
                'name' => 'Cadeaux & Dons',
                'type' => 'income',
                'color' => '#CB99C9',
                'icon' => 'fas fa-gift',
                'description' => 'Cadeaux et dons reçus'
            ],
            [
                'name' => 'Ventes d\'objets',
                'type' => 'income',
                'color' => '#FDFD96',
                'icon' => 'fas fa-tags',
                'description' => 'Ventes d\'objets personnels'
            ],
            [
                'name' => 'Gains de jeux',
                'type' => 'income',
                'color' => '#FFB347',
                'icon' => 'fas fa-dice',
                'description' => 'Gains de jeux et loteries'
            ],
        ];

        // Créer toutes les catégories
        $allCategories = array_merge($expenseCategories, $incomeCategories);
        
        foreach ($allCategories as $categoryData) {
            Category::create(array_merge($categoryData, [
                'user_id' => $user->id,
                'active' => true
            ]));
        }

        $this->command->info('✅ ' . count($allCategories) . ' catégories créées avec succès !');
        $this->command->info('📊 Dépenses: ' . count($expenseCategories) . ' catégories');
        $this->command->info('💰 Revenus: ' . count($incomeCategories) . ' catégories');
    }
}
