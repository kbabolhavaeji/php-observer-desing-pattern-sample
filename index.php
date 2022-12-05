<?php

interface SubjectInterface
{
    public function attach(ObserverInterface $listener);

    public function detach(ObserverInterface $listener);

    public function notify();
}

interface ObserverInterface
{
    public function update(SubjectInterface $subject);
}

interface GameInterface
{
    public function get($item);
}

class GameEventDispatcher implements SubjectInterface
{

    private $listeners;
    public $guess;

    public function __construct()
    {
        $this->listeners = new \SplObjectStorage();
    }

    /**
     * @param ObserverInterface $listener
     * @return void
     */
    public function attach(ObserverInterface $listener): void
    {
        $this->listeners->attach($listener);
    }

    /**
     * @param ObserverInterface $listener
     * @return void
     */
    public function detach(ObserverInterface $listener): void
    {
        $this->listeners->detach($listener);
    }

    /**
     * @return void
     */
    public function notify(): void
    {
        foreach ($this->listeners as $listener) {
            $listener->update($this);
        }
    }
}

class Game implements GameInterface, ObserverInterface
{

    protected GameEventDispatcher $dispatcher;

    public function __construct()
    {
        /** create an instance of GameEventDispatcher to add this class as observer */
        $this->dispatcher = new GameEventDispatcher();
        $this->dispatcher->attach($this);

        /** initiate the game */
        $this->init();
    }

    /**
     * @param SubjectInterface $subject
     * @return void
     */
    public function update(SubjectInterface $subject): void
    {
        (new Process($subject))
            ->checkGameState()
            ->sanitize()
            ->checkTheGuession()
            ->response();
    }

    /**
     * @return mixed
     */
    protected function init()
    {
        // TODO: Use singleton pattern to avoid lost of game data
        // TODO: Implement init() method.
    }

    /**
     * @param $item
     * @return void
     */
    public function get($item): void
    {
        $this->dispatcher->guess = $item;
        $this->dispatcher->notify();
    }
}

class Process
{
    const NUMBER_OF_TRIES = 7;
    protected $result;
    protected $subject;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function checkGameState()
    {
        echo 'd';
        return $this;
    }

    public function sanitize(): static
    {
        // TODO: you can implement some logic for user guess sanitizing :)
        return $this;
    }

    public function checkTheGuession()
    {
        //
        return $this;
    }

    public function response()
    {
        echo $this->result;
    }
}