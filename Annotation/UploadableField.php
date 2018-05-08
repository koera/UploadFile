<?php

namespace Trustylabs\UploadBundle\Annotation;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class UploadableField
 * @package Trustylabs\UploadBundle\Annotation
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class UploadableField{

    /**
     * @var string
     *
     */
    private $filename;

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @var string
     */
    private $path;

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }


    public function __construct(array $options)
    {
        if(empty($options['filename'])){
            throw new \InvalidArgumentException("l'annotation UploadableField doit avoir un attribut 'filename'");
        }
        if(empty($options['path'])){
            throw new \InvalidArgumentException("l'annotation UploadableField doit avoir un attribut 'path'");
        }
        $this->filename = $options['filename'];
        $this->path = $options['path'];

    }

}