<?php

namespace App\Http\Controllers;

use CV\Mat;
use Illuminate\Routing\Controller as BaseController;
use CV\CascadeClassifier, CV\Scalar;
use CV\Rect;
use function CV\{imread, imwrite, cvtColor, equalizeHist, rectangleByRect, haveImageReader, VideoCapture};
use const CV\{COLOR_BGR2GRAY};
use CV\VideoCapture;



class TestController extends BaseController
{
    public function __invoke()
    {
        $this->getPeopleFace();

    }

    public function getPartOfImage()
    {
        $src = imread("test.jpg");
        $src = $src->getImageROI(new Rect(10, 10, 100, 100));
        imwrite("2.jpg", $src);
    }

    public function getPeopleFace()
    {
        $src = imread("test.jpg");

        $gray = cvtColor($src, COLOR_BGR2GRAY);
        $faceClassifier = new CascadeClassifier();
        $faceClassifier->load('haarcascades/haarcascade_frontalface_default.xml');

        $faces = [];
        $faceClassifier->detectMultiScale($gray, $faces);

        if ($faces) {
            $scalar = new Scalar(0, 0, 255); //blue

            foreach ($faces as $face) {
                rectangleByRect($src, $face, $scalar, 4);
            }
        }

        $fileName = strtotime("now") . '.jpg';
        imwrite($fileName, $src);
    }
}
