<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\Parser\Content;
use Ibexa\Contracts\Core\Repository\Exceptions\BadStateException;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Ibexa\Core\Repository\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CarsController extends AbstractController
{
    /**
     * @Route("/catalog", name="all_cars_page")
     * @throws BadStateException
     */
 public function index(Repository $repository): Response
 {
     $filter = new Filter();
     $filter->withCriterion(new Criterion\Visibility(Criterion\Visibility::VISIBLE))->andWithCriterion(new Criterion\ContentTypeIdentifier(['car']));

     $response =$repository->getContentService()->find($filter,[]);
//     var_dump($response);

     return $this->render('@ibexadesign/full/all_cars_view.html.twig', [
         'content_cars' => $response ?? [],
     ]);
 }
}