<?php

namespace Trustylabs\UploadBundle\Handler;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PropertyAccess\PropertyAccess;

class UploadHandler {

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $accessor;


    public function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function uploadFile($entity,$property, $annotation){
        $file = $this->accessor->getValue($entity,$property);
        if($file instanceof UploadedFile){
            $this->removeOldFile($entity,$annotation);
            $filename = $file->getClientOriginalName();
            $file->move($annotation->getPath(),$annotation->getPath() . DIRECTORY_SEPARATOR . $filename);
            $this->accessor->setValue($entity,$annotation->getFilename(),$filename);
        }
    }

    public function setFileFromFileName($entity,$property,$annotation){
        $file = $this->getFileFromFileName($entity,$annotation);
        $this->accessor->setValue($entity,$property,$file);
    } 

    public function removeOldFile($entity,$annotation){
        $file = $this->getFileFromFileName($entity,$annotation);
        if($file !== null)
            @unlink($file->getRealPath());
    }

    private function getFileFromFileName($entity,$annotation){
        $filename = $this->accessor->getValue($entity,$annotation->getFilename());
        if(empty($filename)){
            return null;
        }
        else
            return new File( $annotation->getPath() . DIRECTORY_SEPARATOR. $filename,false);
    }

    public function removeFile($entity,$property){
        $file = $this->accessor->getValue($entity,$property);
        if($file instanceof File){
            @unlink($file->getRealPath());
        }
    }


}