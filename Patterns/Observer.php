<?php

class Subject implements \SplSubject
{
    /**
     * @var int For the sake of simplicity, the Subject's state, essential to
     * all subscribers, is stored in this variable.
     */
    public string $word;

    /**
     * @var \SplObjectStorage List of subscribers. In real life, the list of
     * subscribers can be stored more comprehensively (categorized by event
     * type, etc.).
     */
    private SplObjectStorage $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    /**
     * The subscription management methods.
     */
    public function attach(\SplObserver $observer): void
    {
        echo "Subject: Attached an observer.\n";
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
        echo "Subject: Detached an observer.\n";
    }

    /**
     * Trigger an update in each subscriber.
     */
    public function notify(): void
    {
        echo "Subject: Notifying observers...\n";
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    /**
     * Usually, the subscription logic is only a fraction of what a Subject can
     * really do. Subjects commonly hold some important business logic, that
     * triggers a notification method whenever something important is about to
     * happen (or after it).
     */
    public function scanFile(): void
    {
        $file = "file.txt";
        $content = file_get_contents($file);
        $words = explode(' ', $content);

        foreach ($words as $word) {
            $this->word = $word;

            $this->notify();
        }
    }
}

/**
 * Concrete Observers react to the updates issued by the Subject they had been
 * attached to.
 */
class WordCounterObserver implements \SplObserver
{
    private int $counter = 0;

    public function update(\SplSubject $subject): void
    {
        $this->counter++;
    }
}

class NumberCounterObserver implements \SplObserver
{
    private int $counter = 0;

    public function update(\SplSubject $subject): void
    {
        if (is_numeric($subject->word)) {
            $this->counter++;
        }
    }
}

class LongestWordKeeperObserver implements \SplObserver
{
    private string $word;

    public function update(\SplSubject $subject): void
    {
        if (strlen($subject->word) > strlen($this->word)) {
            $this->word = $subject->word;
        }
    }
}

class ReverseWordObserver implements \SplObserver
{
    public function update(\SplSubject $subject): void
    {
        echo strrev($subject->word) . PHP_EOL;
    }
}

/**
 * The client code.
 */

$subject = new Subject();

$wordCounter = new WordCounterObserver();
$subject->attach($wordCounter);

$numberCounter = new NumberCounterObserver();
$subject->attach($numberCounter);

$longestWordKeeper = new LongestWordKeeperObserver();
$subject->attach($longestWordKeeper);

$reverseWordKeeper = new ReverseWordObserver();
$subject->attach($reverseWordKeeper);

$subject->scanFile();
