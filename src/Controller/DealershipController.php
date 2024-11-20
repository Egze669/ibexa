<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\Parser\Content;
use eZ\Publish\Core\MVC\Symfony\View\View;
use Ibexa\Bundle\Core\Controller;
use Ibexa\Contracts\Core\Repository\Exceptions\BadStateException;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Ibexa\Core\Repository\Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DealershipController extends Controller
{
    /**
     * @throws BadStateException
     */
    public function index(Repository $repository, View $view): View
 {
     $rootLocation = $this->getRootLocation();
     $contentFilter = new Filter();
     $contentFilter
         ->withCriterion(new Criterion\Visibility(Criterion\Visibility::VISIBLE))
         ->andWithCriterion(new Criterion\Subtree($rootLocation->pathString))
         ->andWithCriterion(new Criterion\ContentTypeIdentifier(['car']));

     $response = $repository->getContentService()->find($contentFilter,[]);
    $locationList = [];
     foreach ($response as $item) {
         $locationFilter = new Filter();
         $locationFilter
             ->withCriterion(new Criterion\ContentId($item->getId()))
             ->andWithCriterion(new Criterion\Subtree($rootLocation->pathString));

            foreach ($repository->getLocationService()->find($locationFilter) as $location) {
                $id = $item->getId();
                $locationList[$id] = $location;
            }
     }
     $view->addParameters([
         'carLocations' => $locationList,
         'cars' => $response
     ]);
     return $view;
 }
}