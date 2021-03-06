<?php namespace Controllers;

use App, View;
use Repositories\ImageHandler\ImageHandlerInterface as ImageHandlerInterface;
use Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;

class DashboardController extends BaseController
{
    public function __construct(ImageHandlerInterface $imageHandler, 
        ConfigReaderInterface $reader)
    {
        parent::__construct($imageHandler, $reader);
        $this->imageHandler = $imageHandler;
        $this->reader = $reader;
    }
    
    /****************************
     *  Show dashboard
     */ 
	public function index()
	{
        // ----------------------------------------------------------------------
        // Get last x days from the imagehandler -> move to BaseController
        
        $days = $this->imageHandler->getDays(5);
        
        $lastImage = $this->imageHandler->getLatestImage();
        if($lastImage)
        {
            $lastImage = $lastImage['src'];
        }
        else
        {
            $lastImage = '';
        }

		return View::make('dashboard', [
            'days' => $days,
            'lastImage' => $lastImage,
            'isUpdateAvailable' => $this->isUpdateAvailable()
        ]);
	}
}
