<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use App\Entity\Evenement;
use App\Entity\Filiere;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Données de test réalistes pour SchoolPrepar — TP3
 * Commande : php bin/console doctrine:fixtures:load
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // =============================
        // 1. ÉTABLISSEMENTS (6 records)
        // =============================
        $etablissements = [];

        $data = [
            ['iP Net Institute of Technology', 'IPNIT',  'Lomé',       'Institut Privé',      'contact@ipnit.tg',       '+228 22 20 00 01',
             'IPNIT est un institut d\'enseignement supérieur spécialisé en informatique et technologies numériques, situé à Lomé.'],
            ['ESGIS',                          'ESGIS',  'Cotonou',     'École Privée',        'info@esgis.org',         '+229 21 30 00 02',
             'L\'École Supérieure de Gestion, d\'Informatique et des Sciences est une référence en Afrique de l\'Ouest.'],
            ['EPAC',                           'EPAC',   'Porto-Novo',  'Institut Public',     'epac@uac.bj',            '+229 20 21 33 03',
             'L\'École Polytechnique d\'Abomey-Calavi forme des ingénieurs et techniciens supérieurs.'],
            ['Université de Lomé',             'UL',     'Lomé',        'Université Publique', 'contact@univ-lome.tg',   '+228 22 25 50 04',
             'Première université du Togo, l\'UL accueille plus de 40 000 étudiants dans de nombreuses filières.'],
            ['Institut Africain d\'Informatique', 'IAI', 'Libreville',  'Institut Régional',   'iai@iai-gabon.com',      '+241 01 44 20 05',
             'L\'IAI forme des spécialistes en informatique et systèmes d\'information pour toute l\'Afrique.'],
            ['HECM',                           'HECM',   'Lomé',        'École Privée',        'contact@hecm.tg',        '+228 22 00 10 06',
             'Haute École de Commerce et de Management, propose des filières en gestion et informatique de gestion.'],
        ];

        foreach ($data as [$nom, $sigle, $ville, $type, $email, $tel, $desc]) {
            $e = new Etablissement();
            $e->setNom($nom)
              ->setSigle($sigle)
              ->setVille($ville)
              ->setType($type)
              ->setEmail($email)
              ->setTelephone($tel)
              ->setDescription($desc);

            $manager->persist($e);
            $etablissements[] = $e;
        }

        // =============================
        // 2. FILIÈRES (6 records)
        // =============================
        $filieres = [];

        $fData = [
            [
                'Génie Logiciel', 'Licence 3', '3 ans',
                'Formation complète en développement logiciel : algorithmique, programmation orientée objet, architecture logicielle, génie logiciel, bases de données et gestion de projets informatiques.',
                "Développeur Full-Stack\nArchitecte Logiciel\nChef de Projet IT\nAnalyste Programmeur",
                [0, 1, 2, 3],
            ],
            [
                'Réseaux & Télécommunications', 'Licence 2', '3 ans',
                'Formation en infrastructure réseau, protocoles de communication, administration des systèmes et des réseaux.',
                "Administrateur Réseau\nIngénieur Télécoms\nTechnicien Systèmes",
                [0, 2, 4],
            ],
            [
                'Sécurité Informatique', 'Licence 3', '3 ans',
                'Formation en cybersécurité, ethical hacking et forensic numérique.',
                "Expert Cybersécurité\nPentesteur\nAnalyste SOC\nConsultant Sécurité",
                [0, 1, 3],
            ],
            [
                'Web & Internet Mobile', 'Licence 2', '3 ans',
                'Développement web et mobile (React, Symfony, Flutter, Android).',
                "Développeur Web\nDéveloppeur Mobile\nUX/UI Designer",
                [0, 1, 5],
            ],
            [
                'Intelligence Artificielle & Data Science', 'Master 1', '2 ans',
                'Machine learning, deep learning et analyse de données massives.',
                "Data Scientist\nIngénieur ML\nAnalyste Big Data",
                [3, 4],
            ],
            [
                'Systèmes Embarqués & IoT', 'Licence 3', '3 ans',
                'IoT, électronique et systèmes embarqués.',
                "Ingénieur IoT\nDéveloppeur Embarqué",
                [2, 4],
            ],
        ];

        foreach ($fData as [$nom, $niveau, $duree, $desc, $debouches, $etabIndexes]) {
            $f = new Filiere();
            $f->setNom($nom)
              ->setNiveau($niveau)
              ->setDuree($duree)
              ->setDescription($desc)
              ->setDebouches($debouches);

            foreach ($etabIndexes as $idx) {
                $f->addEtablissement($etablissements[$idx]);
            }

            $manager->persist($f);
            $filieres[] = $f;
        }

        // =============================
        // 3. ÉVÉNEMENTS (6 records)
        // =============================
        $evData = [
            ['Journée Portes Ouvertes IPNIT 2026', 'JPO', '2026-05-15 09:00', 'IPNIT, Lomé',
             'Découvrez nos formations et laboratoires.', 0, 0],

            ['Webinaire : Cybersécurité en Afrique', 'Webinaire', '2026-06-10 14:00', 'En ligne',
             'Conférence sur la cybersécurité en Afrique.', 2, null],

            ['Salon de l\'Étudiant — Lomé 2026', 'Salon', '2026-07-20 08:00', 'Palais des Congrès',
             'Orientation des bacheliers.', null, 3],

            ['Hackathon IA & Innovation', 'Compétition', '2026-08-05 08:00', 'Université de Lomé',
             '48h pour créer une solution IA.', 4, 3],

            ['Atelier Flutter Mobile', 'Atelier', '2026-09-12 10:00', 'ESGIS, Cotonou',
             'Créer des apps mobiles avec Flutter.', 3, 1],

            ['Conférence Numérique Togo', 'Conférence', '2026-10-08 15:00', 'IPNIT, Lomé',
             'Métiers du numérique au Togo.', 0, 0],
        ];

        foreach ($evData as [$titre, $type, $date, $lieu, $desc, $filiereIdx, $etabIdx]) {
            $ev = new Evenement();
            $ev->setTitre($titre)
               ->setType($type)
               ->setDateEvenement(new \DateTime($date))
               ->setLieu($lieu)
               ->setDescription($desc);

            if ($filiereIdx !== null) {
                $ev->setFiliere($filieres[$filiereIdx]);
            }

            if ($etabIdx !== null) {
                $ev->setEtablissement($etablissements[$etabIdx]);
            }

            $manager->persist($ev);
        }

        // =============================
        // 4. USERS (AJOUT FINAL)
        // =============================
        $usersData = [
            ['TCHANI',  'Wadou Djawada',  'djawada@ipnit.tg',        '+228 91 00 00 01', 'ROLE_ADMIN',         true],
            ['AGBESSI', 'Koffi Edem',     'koffi.agbessi@gmail.com', '+228 92 11 22 33', 'ROLE_ETUDIANT',      true],
            ['MENSAH',  'Akossiwa',       'akossiwa@gmail.com',      '+228 93 44 55 66', 'ROLE_ETUDIANT',      true],
            ['KPONTON', 'Dodji Fréjus',   'frejus@ub.tg',            '+229 97 12 34 56', 'ROLE_ETABLISSEMENT', true],
            ['AMEVOR',  'Sénamé',         'senam@yahoo.fr',          '+228 90 66 77 88', 'ROLE_ETUDIANT',      true],
            ['LAWSON',  'Yao Komlan',     'yao@esgis.org',           '+229 95 00 11 22', 'ROLE_ETABLISSEMENT', false],
        ];

        foreach ($usersData as [$nom, $prenom, $email, $tel, $role, $actif]) {
            $u = new User();
            $u->setNom($nom)
              ->setPrenom($prenom)
              ->setEmail($email)
              ->setTelephone($tel)
              ->setRole($role)
              ->setActif($actif);

            $manager->persist($u);
        }

        // =============================
        // FLUSH FINAL
        // =============================
        $manager->flush();
    }
}