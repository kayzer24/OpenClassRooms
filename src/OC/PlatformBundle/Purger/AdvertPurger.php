<?php
namespace OC\PlatformBundle\Purger;

use Doctrine\ORM\EntityManagerInterface;

class AdvertPurger
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function purge($days)
    {
        $advertRepo = $this->em->getRepository('OCPlatformBundle:Advert');
        $advertSkillRepo = $this->em->getRepository('OCPlatformBundle:AdvertSkill');
        $advertApplicationRepo = $this->em->getRepository('OCPlatformBundle:Application');

        $date = new \DateTime($days.' days ago');

        //on récupere les annonces a supprimer
        $listAdverts = $advertRepo->getAdvertsBefore($date);

        //on parcours les annonces pour les supprimer
        foreach ($listAdverts as $advert)
        {
            // On recupere les applications liées a l'annonce
            $advertApplications = $advertApplicationRepo->findBy(['advert' => $advert]);

            foreach ($advertApplications as $advertApplication)
            {
                $this->em->remove($advertApplication);
            }

            //on recupere les advert skills liées a l'annonce
            $advertSkills = $advertSkillRepo->findBy(['advert' => $advert]);

            foreach ($advertSkills as $advertSkill)
            {
                $this->em->remove($advertSkill);
            }

            $this->em->remove($advert);
        }
        $this->em->flush();
    }
}