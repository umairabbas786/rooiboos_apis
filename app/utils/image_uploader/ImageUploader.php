<?php

class ImageUploader {

    /** @var string */
    private string $name;

    /** @var string */
    private string $src;

    /** @var string */
    private string $dest_dir;

    /** @var int */
    private int $quality = 60;

    /**
     * @var false|GdImage|resource
     */
    private $image;

    /**
     * ImageUploader constructor.
     * @param $src
     */
    private function __construct($src) {
        $this->src = $src;
        $this->createImageFromSource();
    }

    /**
     * Sets Destination Directory where image will be saved
     * @param string $dest_dir <p> Destination Directory Path </p>
     * @return $this
     */
    public function destinationDir(string $dest_dir): ImageUploader {
        $this->dest_dir = $dest_dir;
        if (!file_exists($this->dest_dir)) {
            mkdir($this->dest_dir, 0777, true);
        }
        return $this;
    }

    /**
     * Compresses the image with specified quality,
     * if method not called, image will be compressed at 60 by default
     *
     * @param int $quality <p> Image Compression Quality </p>
     * @return $this
     */
    public function compressQuality(int $quality): ImageUploader {
        $this->quality = $quality;
        return $this;
    }

    /**
     * Uses the specified name for image
     * originalFileName can be retrieved from $_FILES['img_file']['name']
     *
     * @param string $name - name which will be used for image
     * @return $this
     */
    public function useName(string $name): ImageUploader {
        $this->name = $name;
        return $this;
    }

    /**
     * Generates Unique name from specified name for image
     * originalFileName can be retrieved from $_FILES['img_file']['name']
     *
     * @param string $name <p> Any name for image, this will be made unique </p>
     * @return $this
     */
    public function generateUniqueName(string $name): ImageUploader {
        $tmp = explode(".", $name); // https://stackoverflow.com/questions/4636166/only-variables-should-be-passed-by-reference
        $this->name = time() . rand(0, 99999) . "." . end($tmp); // generating name likely to be unique
        return $this;
    }

    /**
     * Maps the Generated Name to specified variable.
     * Use only if you have used generateUniqueName() method to generate unique name,
     * And you want that generated unique name
     *
     * @param string $var <p> Generated Name will be mapped to this variable </p>
     * @return $this
     */
    public function mapGeneratedName(string &$var): ImageUploader {
        $var = $this->name;
        return $this;
    }

    private function createImageFromSource() {
        $info = getimagesize($this->src);

        switch ($info['mime']) {
            case 'image/webp':
                $this->image = imagecreatefromwebp($this->src);
                break;
            case 'image/jpeg':
                $this->image = imagecreatefromjpeg($this->src);
                break;
            case 'image/png':
                $this->image = imagecreatefrompng($this->src);
                break;
            case 'image/gif':
                $this->image = imagecreatefromgif($this->src);
                break;
            case 'image/bmp':
                $this->image = imagecreatefrombmp($this->src);
                break;
        }
    }

    /**
     * Saves Image to specified location
     * @return bool true if saved else false
     */
    public function save(): bool {
        return imagejpeg($this->image, $this->dest_dir . '/' . $this->name, $this->quality); // Compress and save to destination
    }

    /**
     * @param string $src <p> actual image file path i.e. $_FILES['img_file']['tmp_name'] </p>
     * @return ImageUploader
     */
    public static function withSrc(string $src): ImageUploader {
        return new ImageUploader($src);
    }
}
