<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Organization;
use App\Entity\Style;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class RotterdamFixtures extends Fixture
{
    private $params;
    /**
     * @var CommonGroundService
     */
    private $commonGroundService;

    public function __construct(ParameterBagInterface $params, CommonGroundService $commonGroundService)
    {
        $this->params = $params;
        $this->commonGroundService = $commonGroundService;
    }

    public function load(ObjectManager $manager)
    {
        if (
            !$this->params->get('app_build_all_fixtures')
            //$this->params->get('app_domain') != 'zuiddrecht.nl' && strpos($this->params->get('app_domain'), 'zuiddrecht.nl') == false &&
            //$this->params->get('app_domain') != 'zuid-drecht.nl' && strpos($this->params->get('app_domain'), 'zuid-drecht.nl') == false
        ) {
            return false;
        }

        // Rotterdam
        $id = Uuid::fromString('caf824b3-436a-471c-a703-629cf84ca00d');
        $rotterdam = new Organization();
        $rotterdam->setName('Rotterdam');
        $rotterdam->setDescription('Gemeente Rotterdam');
        $rotterdam->setRsin('');
        $manager->persist($rotterdam);
        $rotterdam->setId($id);
        $manager->persist($rotterdam);
        $manager->flush();
        $rotterdam = $manager->getRepository('App:Organization')->findOneBy(['id'=> $id]);

        $favicon = new Image();
        $favicon->setName('Rotterdam Favicon');
        $favicon->setDescription('Favicon VNG');
        $favicon->setOrganization($rotterdam);

        $logo = new Image();
        $logo->setName('Rotterdam Logo');
        $logo->setDescription('Logo VNG');
        $logo->setOrganization($rotterdam);

        $style = new Style();
        $style->setName('Rotterdam');
        $style->setDescription('Huistlijl Gemeente Utrecht');
        $style->setCss('');
        $style->setfavicon($favicon);
        $style->setOrganization($rotterdam);

        $rotterdam->setLogo($logo);

        $manager->persist($rotterdam);
        $manager->persist($favicon);
        $manager->persist($logo);
        $manager->persist($style);

        $manager->flush();
    }
}
