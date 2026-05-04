<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use App\Entity\Evenement;
use App\Entity\Filiere;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // ── Admin user ──
        $admin = new User();
        $admin->setNom('ADMIN')
              ->setPrenom('SchoolPrepar')
              ->setEmail('admin@schoolprepar.tg')
              ->setRoles(['ROLE_ADMIN'])
              ->setPassword($this->encoder->encodePassword($admin, 'admin123'))
              ->setActif(true);
        $manager->persist($admin);

        // ── Regular user ──
        $user = new User();
        $user->setNom('ETUDIANT')
             ->setPrenom('Demo')
             ->setEmail('etudiant@schoolprepar.tg')
             ->setRoles(['ROLE_USER'])
             ->setPassword($this->encoder->encodePassword($user, 'user123'))
             ->setActif(true);
        $manager->persist($user);

        // ── Etablissements ──
        $etablissements = [];
        $etabData = [
            ['Institut Polytechnique Nouvelles Technologies', 'IPNIT', 'Lomé', 'Institut privé'],
            ['Université de Lomé', 'UL', 'Lomé', 'Université publique'],
            ['Institut Africain de Management', 'IAM', 'Lomé', 'Institut privé'],
            ['École Supérieure de Gestion et Informatique', 'ESGI', 'Lomé', 'Grande école'],
        ];
        foreach ($etabData as $data) {
            $e = new Etablissement();
            $e->setNom($data[0])
              ->setSigle($data[1])
              ->setVille($data[2])
              ->setType($data[3])
              ->setDescription('Établissement de formation supérieure au Togo.')
              ->setEmail(strtolower($data[1]) . '@exemple.tg')
              ->setTelephone('+228 90 00 00 00');
            $manager->persist($e);
            $etablissements[] = $e;
        }

        // ── Filières ──
        $filiereData = [
            ['Génie Logiciel', 'Licence 3', '3 ans', 'Formation en développement logiciel.', 'Développeur, Architecte logiciel'],
            ['Web & Internet Mobile', 'Licence 3', '3 ans', 'Formation en développement web et mobile.', 'Développeur web, Développeur mobile'],
            ['Réseaux & Télécommunications', 'Licence 3', '3 ans', 'Formation en administration réseaux.', 'Administrateur réseau'],
            ['Comptabilité & Finance', 'Licence 3', '3 ans', 'Formation en comptabilité et gestion.', 'Comptable, Analyste financier'],
            ['Master Intelligence Artificielle', 'Master 2', '2 ans', 'Formation en IA et machine learning.', 'Data Scientist, Ingénieur IA'],
        ];
        foreach ($filiereData as $data) {
            $f = new Filiere();
            $f->setNom($data[0])
              ->setNiveau($data[1])
              ->setDuree($data[2])
              ->setDescription($data[3])
              ->setDebouches($data[4]);
            $f->addEtablissement($etablissements[0]);
            $manager->persist($f);
        }

        // ── Evenements ──
        $evData = [
            ['Journée Portes Ouvertes IPNIT 2025', 'JPO', '+15 days', 'Campus IPNIT, Lomé'],
            ['Salon de l\'Étudiant Lomé 2025', 'Salon', '+30 days', 'Palais des Congrès, Lomé'],
            ['Webinaire: Carrières dans le numérique', 'Webinaire', '+7 days', 'En ligne'],
        ];
        foreach ($evData as $data) {
            $ev = new Evenement();
            $ev->setTitre($data[0])
               ->setType($data[1])
               ->setDateEvenement(new \DateTime($data[2]))
               ->setLieu($data[3])
               ->setDescription('Venez découvrir nos formations et rencontrer nos équipes.')
               ->setEtablissement($etablissements[0]);
            $manager->persist($ev);
        }

        $manager->flush();
    }
}