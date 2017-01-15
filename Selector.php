<?php
namespace VirtualComplete\Selector;

abstract class Selector
{
    public $caseSensitiveMappings = true;
    protected $commonInterface = '';
    protected $mappings = [];

    public function __construct()
    {
        $this->boot();
    }

    /**
     * Boots the class (loads mappings and common interface)
     */
    final public function boot()
    {
        $this->mappings = $this->setMappings();
        $this->commonInterface = $this->setInterface();
    }

    /**
     * @param array|string $arguments
     * @return object
     * @throws SelectorException
     */
    final public function selectFrom($arguments)
    {
        $mappings = $this->getMappings();
        $key = $this->getKey($arguments);

        if ($this->caseSensitiveMappings == false) {
            $key = mb_strtolower($key);
            $mappings = $this->arrayKeysStrtolower($mappings);
        }

        if (!isset($mappings[$key])) {
            $key = $this->defaultKey();
            if (!$key || !isset($mappings[$key])) {
                throw new SelectorException('No valid mapping could be found.');
            }
        }

        $class = $mappings[$key];
        if ($this->isAnInstance($class)) {
            return $class;
        }
        return new $class;
    }

    /**
     * @return string
     */
    final public function getInterface()
    {
        return $this->commonInterface;
    }

    /**
     * @return string
     */
    abstract protected function setInterface();

    /**
     * @return array
     * @throws SelectorException
     */
    final public function getMappings()
    {
        if (!is_array($this->mappings)) {
            throw new SelectorException('Expected mappings to be an array, retrieved ' . gettype($this->mappings));
        }
        foreach ($this->mappings as $class) {
            if (!in_array($this->commonInterface, class_implements($class))) {
                throw new SelectorException($class . ' does not implement the common interface: ' . $this->commonInterface);
            }
        }
        return $this->mappings;
    }

    /**
     * Set the mappings of a key => class.  The class can be a string or an existing instance.
     *
     * @return array
     */
    abstract protected function setMappings();

    /**
     * Use this key as a fallback if a key cannot be retrieved from getKey(), or return null to throw a SelectorException.
     *
     * @return string|null
     */
    abstract protected function defaultKey();

    /**
     * Evaluate the arguments and return a mapping key.  Returning null here will fall back to the defaultKey().
     *
     * @param array|string $arguments
     * @return string|null
     */
    abstract protected function getKey($arguments);

    /**
     * Check if the argument is an instance of the common interface
     *
     * @param $class
     * @return bool
     */
    protected function isAnInstance($class)
    {
        return ($class instanceof $this->commonInterface);
    }

    /**
     * Map all array keys to lower case for case insensitivity
     *
     * @param $array
     * @return mixed
     */
    protected function arrayKeysStrtolower($array)
    {
        $return = [];
        foreach ($array as $key => $value) {
            $return[mb_strtolower($key)] = $value;
        }
        return $return;
    }
}
