<?php

namespace Rokka\Client\Core;

/**
 * Stack Collection
 *
 * Holds an array of stacks
 */
class StackCollection implements \Countable
{
    /**
     * @var array
     */
    private $stacks = array();

    /**
     * Constructor.
     *
     * @param array $stacks Array of stacks
     */
    public function __construct(array $stacks)
    {
        foreach ($stacks as $stack) {
            if (!($stack instanceof Stack)) {
                throw new \LogicException('You can only use Stack inside StackCollection');
            }
        }

        $this->stacks = $stacks;
    }

    /**
     * Return the count of the collection
     *
     * @return integer
     */
    public function count()
    {
        return count($this->stacks);
    }

    /**
     * Return the stacks
     *
     * @return Stack[]
     */
    public function getStacks()
    {
        return $this->stacks;
    }

    /**
     * Create a stack from the JSON data.
     *
     * @param string|array $data    JSON data
     * @param boolean      $isArray If the data provided is already an array
     *
     * @return StackCollection
     */
    public static function createFromJsonResponse($data, $isArray = false)
    {
        if (!$isArray) {
            $data = json_decode($data, true);
        }

        $stacks = array_map(function ($stack) {
            return Stack::createFromJsonResponse($stack, true);
        }, $data['items']);

        return new StackCollection($stacks);
    }
}