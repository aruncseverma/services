<?php
/**
 * repository for filters
 *
 * @author Jhay Bagas <bagas.jhay@gmail.com>
 */
namespace App\Repository;

use App\Models\Attribute;
use App\Models\EscortRate;
use App\Models\UserData;
use App\Models\UserLocation;
use App\Models\UserReview;
use App\Models\UserVideo;

class FilterRepository extends Repository
{
    protected $attributeModel;

    protected $userDataModel;

    protected $escortRateModel;

    protected $userVideoModel;

    protected $userReviewModel;

    protected $userLocationModel;

    public function __construct(Attribute $attribute, UserData $userData, EscortRate $rate, 
        UserVideo $video, UserReview $review, UserLocation $location)
    {
        $this->attributeModel = $attribute;
        $this->userDataModel = $userData;
        $this->escortRateModel = $rate;
        $this->userVideoModel = $video;
        $this->userReviewModel = $review;
        $this->userLocationModel = $location;
    }

    public function getEscortFilter()
    {

    }

    public function getRatesFilter()
    {

    }

    public function getAgeFilter()
    {

    }

    public function getVideoFilter()
    {

    }

    public function getEthnicityFilter()
    {

    }

    public function getHeightFilter()
    {

    }

    public function getReviewFilter()
    {
        
    }
}