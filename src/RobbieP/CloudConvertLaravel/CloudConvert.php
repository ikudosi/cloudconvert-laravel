<?php namespace RobbieP\CloudConvertLaravel;

/*
|--------------------------------------------------------------------------
| CloudConvert Laravel API
|--------------------------------------------------------------------------
|
| CloudConvert is a file conversion service. Convert anything to anything
| more than 100 different audio, video, document, ebook, archive, image,
| spreadsheet and presentation formats supported.
|
*/

use CloudConvert\Api;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;


class CloudConvert
{
    private $api;
    private $process;

    /**
     * Configuration options
     * @var Config
     */
    private $config;
    private $api_key;
    private $resource;

    /**
     * @param $config
     * @internal param null $api_key
     */
    function __construct($config = null)
    {
        $this->setConfig($config);
        $this->setFilesystem();
    }

    /**
     * @param mixed $api
     * @return CloudConvert
     */
    public function setApi($api)
    {
        $this->checkAPIkey();
        $this->api = !is_null($api) ? $api : new Api($this->api_key);
        return $this;
    }

    /**
     * @param Config $config
     */
    public function setConfig($config = null)
    {
        if(is_array($config))
            $this->config = new Config($config);
        if(is_object($config))
            $this->config = $config;
        $this->api_key = is_string($config) ? $config : (is_object($this->config) ? $this->config->get('api_key') : null  );
    }

    /**
     * @param mixed $process
     * @return CloudConvert
     */
    public function setProcess($process = null)
    {
        $this->process = $process;
        return $this;
    }

    /**
     * @param Filesystem $fileSystem
     */
    public function setFilesystem($fileSystem = null)
    {
        $this->fileSystem = (!is_null($fileSystem)) ? $fileSystem : new Filesystem;
    }

    /**
     * @return mixed
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @return mixed
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     *
     */
    private function checkAPIkey()
    {
        if (!$this->hasApiKey()) {
            throw new \InvalidArgumentException('No API key provided.');
        }
    }

    /**
     * @return bool
     */
    public function hasApiKey()
    {
        return !empty($this->api_key);
    }

    /**
     * @param $resource
     * @param $inputFormat
     * @param null $outputFormat
     */
    public function make($resource, $inputFormat, $outputFormat = null)
    {
        $this->resource = $resource;
        $this->outputFormat = is_null($outputFormat) ? $inputFormat : $outputFormat;

        //init
    }

}
